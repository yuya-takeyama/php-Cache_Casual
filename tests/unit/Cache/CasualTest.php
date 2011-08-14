<?php
/**
 * Test class for Cache_Casual.
 */
class Cache_CasualTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function offsetGet_should_be_the_data_it_is_set()
    {
        $cache = $this->createCacheWithLifetime(3600);
        $input = $expected = 'some data';
        $cache['foo'] = $input;
        $this->assertSame($expected, $cache['foo']);
    }

    /**
     * @test
     */
    public function offsetGet_should_be_NULL_if_the_data_is_expired()
    {
        $cache = $this->createCacheWithLifetime(0);
        $cache['foo'] = 'some data';
        $this->assertNull($cache['foo']);
    }

    /**
     * @test
     */
    public function offsetGet_should_be_NULL_if_the_data_is_not_set()
    {
        $cache = $this->createCacheWithLifetime(3600);
        $this->assertNull($cache['foo']);
    }

    /**
     * @test
     */
    public function offsetGet_should_be_NULL_after_the_data_is_unset()
    {
        $cache = $this->createCacheWithLifetime(3600);
        $cache['foo'] = 'some data';
        unset($cache['foo']);
        $this->assertNull($cache['foo']);
    }

    /**
     * @test
     */
    public function offsetExists_should_be_true_if_the_data_specified_with_key_exists()
    {
        $cache = $this->createCacheWithLifetime(3600);
        $input = $expected = 'some data';
        $cache['foo'] = $input;
        $this->assertTrue(isset($cache['foo']));
    }

    /**
     * @test
     */
    public function offsetExists_should_be_false_if_the_data_specified_with_key_is_expired()
    {
        $cache = $this->createCacheWithLifetime(0);
        $cache['foo'] = 'some data';
        $this->assertFalse(isset($cache['foo']));
    }

    /**
     * @test
     */
    public function offsetExists_should_be_false_if_the_data_specified_with_key_is_not_set()
    {
        $cache = $this->createCacheWithLifetime(3600);
        $this->assertFalse(isset($cache['foo']));
    }

    /**
     * @test
     */
    public function offsetExists_should_be_false_after_the_data_specified_with_key_is_unset()
    {
        $cache = $this->createCacheWithLifetime(3600);
        $cache['foo'] = 'some data';
        unset($cache['foo']);
        $this->assertFalse(isset($cache['foo']));
    }

    /**
     * Creation method for Cache_Casual with lifetime.
     *
     * @param  int $lifetime
     * @return Cache_Casual
     */
    protected function createCacheWithLifetime($lifetime)
    {
        $container = new Cache_Casual_Container_Memory;
        return new Cache_Casual($container, $lifetime);
    }
}
