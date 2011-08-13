<?php
/**
 * Test class for Cache_Casual_DataFactory.
 */
class Cache_Casual_DataFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Cache_Casual_DataFactory
     */
    protected $factory;

    /**
     * Default lifetime of the DataFactory.
     *
     * @var int
     */
    protected $defaultLifetime;

    public function setUp()
    {
        $this->defaultLifetime = 3600;
        $this->factory = new Cache_Casual_DataFactory($this->defaultLifetime);
    }

    /**
     * @test
     */
    public function create_should_create_Data_has_the_default_lifetime()
    {
        $data = $this->factory->create('foo');
        $this->assertSame($this->defaultLifetime, $data->getLifetime());
    }

    /**
     * @test
     */
    public function create_should_create_Data_has_the_data_as_its_content()
    {
        $input = $expected = 'foo';
        $data = $this->factory->create($input);
        $this->assertSame($expected, $data->getContent());
    }
}
