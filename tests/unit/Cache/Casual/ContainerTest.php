<?php
/**
 * Test class for Cache_Casual_Container_***
 */
class Cache_Casual_ContainerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        vfsStream::setup('dir');
    }

    /**
     * @test
     * @dataProvider containerProvider
     */
    public function get_should_be_the_data_it_is_set($container)
    {
        $input = $expected = 'bar';
        $container->set('foo', $input);
        $this->assertSame($expected, $container->get('foo'));
    }

    /**
     * @test
     * @dataProvider zeroLifetimeContainerProvider
     */
    public function get_should_be_NULL_if_the_data_is_expired($container)
    {
        $container->set('foo', 'bar');
        $this->assertNull($container->get('foo'));
    }

    /**
     * @test
     * @dataProvider containerProvider
     */
    public function get_should_be_NULL_after_the_data_is_deleted($container)
    {
        $container->set('foo', 'bar');
        $container->delete('foo');
        $this->assertNull($container->get('foo'));
    }

    /**
     * @test
     * @dataProvider containerProvider
     */
    public function has_should_be_true_if_the_data_specified_with_key_is_not_expired($container)
    {
        $container->set('foo', 'bar');
        $this->assertTrue($container->has('foo'));
    }

    /**
     * @test
     * @dataProvider containerProvider
     */
    public function has_should_be_false_if_the_data_specified_with_key_is_not_set($container)
    {
        $this->assertFalse($container->has('foo'));
    }

    /**
     * @test
     * @dataProvider zeroLifetimeContainerProvider
     */
    public function has_should_be_false_if_the_data_specified_with_key_is_expired($container)
    {
        $container->set('foo', 'bar');
        $this->assertFalse($container->has('foo'));
    }

    /**
     * @test
     * @dataProvider containerProvider
     */
    public function has_should_be_false_after_the_data_is_deleted($container)
    {
        $container->set('foo', 'bar');
        $container->delete('foo');
        $this->assertFalse($container->has('foo'));
    }

    /**
     * Creation method for Cache_Casual_Container_Memory with lifetime.
     *
     * @param  int $lifetime
     * @return Cache_Casual_Container_Memory
     */
    protected function createContainerWithLifetime($lifetime)
    {
        $dataFactory = new Cache_Casual_DataFactory($lifetime);
        $container = new Cache_Casual_Container_Memory;
        $container->setDataFactory($dataFactory);
        return $container;
    }

    /**
     * Data provider of cache containers with DataFactory has long lifetime.
     *
     * @return array
     */
    public function containerProvider()
    {
        return $this->createContainersWithLifetime(3600);
    }

    /**
     * Data provider of cache containers with DataFactory has no lifetime.
     *
     * @return array
     */
    public function zeroLifetimeContainerProvider()
    {
        return $this->createContainersWithLifetime(0);
    }

    /**
     * Creation method for cache containers under test.
     *
     * @return array
     */
    protected function createContainersUnderTest()
    {
        return array(
            new Cache_Casual_Container_Memory,
            new Cache_Casual_Container_File(vfsStream::url('dir')),
        );
    }

    /**
     * Creation method for cache containers with DataFactory has lifetime.
     *
     * @return array
     */
    protected function createContainersWithLifetime($lifetime)
    {
        $data = array();
        foreach ($this->createContainersUnderTest() as $container) {
            $dataFactory = new Cache_Casual_DataFactory($lifetime);
            $container->setDataFactory($dataFactory);
            $data[] = array($container);
        }
        return $data;
    }
}
