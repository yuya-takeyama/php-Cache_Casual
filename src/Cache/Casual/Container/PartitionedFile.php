<?php
/**
 * Cache_Casual
 *
 * A casual way to cache your data with PHP.
 *
 * @package Cache_Casual
 * @author  Yuya Takeyama <sign.of.the.wolf.pentagram at gmail.com>
 */

require_once dirname(__FILE__) . '/File.php';

/**
 * Partitioned File cache container.
 *
 * Stores cache data as serialized format into file.
 * Files are saved in partioned directory named with its prefix.
 *
 * @author Yuya Takeyama
 */
class Cache_Casual_Container_PartitionedFile extends Cache_Casual_Container_File
{
    /**
     * @see Cache_Casual_ContainerInterface::set()
     */
    public function set($key, $value)
    {
        $data = $this->createData($value);
        $file = $this->_getFilePath($key);
        $dir  = dirname($file);

        @mkdir($dir);

        $fp = fopen($this->_getFilePath($key), 'w');
        if (flock($fp, LOCK_EX)) {
            fputs($fp, $this->_serialize($data));
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

    /**
     * Gets file path from cache key.
     *
     * @param  string $key
     * @return string
     */
    protected function _getFilePath($key)
    {
        $hash   = $this->_generateHash($key);
        $prefix = substr($hash, 0, 2);
        return $this->_directory . DIRECTORY_SEPARATOR .
            $prefix .  DIRECTORY_SEPARATOR .
            $hash . '.cache';
    }
}
