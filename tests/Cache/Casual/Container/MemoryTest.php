<?php
/**
 * Test class for Cache_Casual_Container_Memory.
 */
class Cache_Casual_Container_MemoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function get_should_be_the_data_it_is_set()
    {
        $container = $this->createContainerWithLifetime(3600);
        $input = $expected = 'bar';
        $container->set('foo', $input);
        $this->assertSame($expected, $container->get('foo'));
    }

    /**
     * @test
     */
    public function get_should_be_NULL_if_the_data_is_expired()
    {
        $container = $this->createContainerWithLifetime(0);
        $container->set('foo', 'bar');
        $this->assertNull($container->get('foo'));
    }

    /**
     * @test
     */
    public function get_should_be_NULL_after_the_data_is_deleted()
    {
        $container = $this->createContainerWithLifetime(3600);
        $container->set('foo', 'bar');
        $container->delete('foo');
        $this->assertNull($container->get('foo'));
    }

    /**
     * @test
     */
    public function has_should_be_true_if_the_data_specified_with_key_is_not_expired()
    {
        $container = $this->createContainerWithLifetime(3600);
        $container->set('foo', 'bar');
        $this->assertTrue($container->has('foo'));
    }

    /**
     * @test
     */
    public function has_should_be_false_if_the_data_specified_with_key_is_not_set()
    {
        $container = $this->createContainerWithLifetime(3600);
        $this->assertFalse($container->has('foo'));
    }

    /**
     * @test
     */
    public function has_should_be_false_if_the_data_specified_with_key_is_expired()
    {
        $container = $this->createContainerWithLifetime(0);
        $container->set('foo', 'bar');
        $this->assertFalse($container->has('foo'));
    }

    /**
     * @test
     */
    public function has_should_be_false_after_the_data_is_deleted()
    {
        $container = $this->createContainerWithLifetime(3600);
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
}
