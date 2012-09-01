<?php
/**
 * Test class for Cache_Casual_Container_PartitionedFile
 */
class Cache_Casual_Container_PartitionedFileTest extends PHPUnit_Framework_TestCase
{
    const VFS_ROOT = 'root';

    /**
     * @var Cache_Casual_Container_PartitionedFile
     */
    protected $container;

    public function setUp()
    {
        vfsStream::setup(self::VFS_ROOT);
        $dataFactory = new Cache_Casual_DataFactory(3600);
        $this->container = new Cache_Casual_Container_PartitionedFile(vfsStream::url(self::VFS_ROOT));
        $this->container->setDataFactory($dataFactory);
    }

    /**
     * @test
     */
    public function get_should_be_NULL_if_the_cache_file_is_broken()
    {
        $this->setUpBrokenCacheFile('foo');
        $this->assertNull($this->container->get('foo'));
    }

    /**
     * @test
     */
    public function has_should_be_false_if_the_cache_file_is_broken()
    {
        $this->setUpBrokenCacheFile('foo');
        $this->assertFalse($this->container->has('foo'));
    }

    /**
     * @test
     */
    public function set_should_create_cache_file()
    {
        $this->container->set('foo', 'bar');

        $this->assertTrue(file_exists($this->getCacheFilePathForKey('foo')));
    }

    /**
     * @test
     */
    public function set_should_store_value()
    {
        $obj = new ArrayObject(array("foo", "bar", "baz"));
        $this->container->set('foo', $obj);
        $this->assertEquals($obj, $this->container->get('foo'));
    }

    /**
     * Sets up broken cache file of specified cache key.
     *
     * @param  string $key
     * @return void
     */
    protected function setUpBrokenCacheFile($key)
    {
        $file = $this->getCacheFilePathForKey($key);
        mkdir(dirname($file));
        $fp = fopen($file, 'w');
        fputs($fp, '***BROKEN_STRING***');
        fclose($fp);
    }

    private function getCacheFilePathForKey($key)
    {
        $hash   = sha1($key);
        $prefix = substr($hash, 0, 2);
        return vfsStream::url(self::VFS_ROOT) . '/' . $prefix . '/' . $hash . '.cache';
    }
}
