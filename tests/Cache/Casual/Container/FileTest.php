<?php
/**
 * Test class for Cache_Casual_Container_File
 */
class Cache_Casual_Container_FileTest extends PHPUnit_Framework_TestCase
{
    const VFS_ROOT = 'root';

    /**
     * @var Cache_Casual_Container_File
     */
    protected $container;

    public function setUp()
    {
        vfsStream::setup(self::VFS_ROOT);
        $dataFactory = new Cache_Casual_DataFactory(3600);
        $this->container = new Cache_Casual_Container_File(vfsStream::url(self::VFS_ROOT));
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
     * Sets up broken cache file of specified cache key.
     *
     * @param  string $key
     * @return void
     */
    protected function setUpBrokenCacheFile($key)
    {
        $file = vfsStream::url(self::VFS_ROOT) . '/' . sha1($key) . '.cache';
        $fp = fopen($file, 'w');
        fputs($fp, '***BROKEN_STRING***');
        fclose($fp);
    }
}
