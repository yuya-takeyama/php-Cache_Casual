<?php
/**
 * Cache_Casual.
 */

/**
 * File cache container.
 *
 * @author Yuya Takeyama
 */
class Cache_Casual_Container_File extends Cache_Casual_ContainerAbstract
{
    /**
     * Directory to store cache files.
     *
     * @var string
     */
    protected $_directory;

    /**
     * Constructor.
     *
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->_directory = $directory;
    }

    /**
     * @see Cache_Casual_ContainerInterface::set()
     */
    public function set($key, $value)
    {
        $data = $this->createData($value);
        $fp = fopen($this->_getFilePath($key), 'w');
        fputs($fp, $this->_toJson($data));
        fclose($fp);
    }

    /**
     * @see Cache_Casual_ContainerInterface::get()
     */
    public function get($key)
    {
        $data = $this->_fetchData($key);
        if (isset($data) && $data->isNotExpired()) {
            return $data->getContent();
        }
    }

    /**
     * @see Cache_Casual_ContainerInterface::has()
     */
    public function has($key)
    {
        $data = $this->_fetchData($key);
        return isset($data) && $data->isNotExpired();
    }

    /**
     * @see Cache_Casual_ContainerInterface::delete()
     */
    public function delete($key)
    {
        if ($this->_fileExists($key)) {
            unlink($this->_getFilePath($key));
        }
    }

    /**
     * Whether the file of the key exists.
     *
     * @param  string $key
     * @return bool
     */
    protected function _fileExists($key)
    {
        return file_exists($this->_getFilePath($key));
    }

    /**
     * Load cache file and returns Cache_Casual_Data.
     *
     * @param  string $key
     * @return Cache_Casual_Data
     */
    protected function _fetchData($key)
    {
        if ($this->_fileExists($key)) {
            $file = $this->_getFilePath($key);
            return $this->_fromJson(file_get_contents($file));
        }
    }

    /**
     * Converts from Cache_Casual_Data to JSON string.
     *
     * @param  Cache_Casual_Data
     * @return string
     */
    protected function _toJson(Cache_Casual_Data $data)
    {
        return json_encode(array(
            'last_modified' => $data->getLastModified(),
            'lifetime'      => $data->getLifetime(),
            'content'       => $data->getContent(),
        ));
    }

    /**
     * Converts from JSON string to Cache_Casual_Data.
     *
     * @param  string $json
     * @return Cache_Casual_Data
     */
    protected function _fromJson($json)
    {
        $data = json_decode($json, true);
        $lastModified = new DateTime(
            $data['last_modified']['date'],
            new DateTimeZone($data['last_modified']['timezone'])
        );
        return new Cache_Casual_Data(array(
            'lifetime'      => $data['lifetime'],
            'last_modified' => $lastModified,
            'content'       => $data['content'],
        ));
    }

    /**
     * Gets file path from cache key.
     *
     * @param  string $key
     * @return string
     */
    protected function _getFilePath($key)
    {
        return $this->_directory . '/' . $this->_generateHash($key) . '.cache';
    }

    /**
     * Generates hash of cache key.
     *
     * @param  string $key
     * @return string
     */
    protected function _generateHash($key)
    {
        return sha1($key);
    }
}
