<?php
/**
 * Cache_Casual
 *
 * A casual way to cache your data with PHP.
 *
 * @package Cache_Casual
 * @author  Yuya Takeyama <sign.of.the.wolf.pentagram at gmail.com>
 */

/**
 * Namespace PDO container.
 *
 * Stores cache data as serialized format into database table using PDO.
 * The table is separated with namespace
 *
 * @author Yuya Takeyama
 */
class Cache_Casual_Container_NamespacePdo extends Cache_Casual_ContainerAbstract
{
    const MAX_NAMESPACE_LENGTH = 64;
    const MAX_KEY_LENGTH       = 255;

    /**
     * @var PDO
     */
    private $_pdo;

    /**
     * @var string
     */
    private $_table;

    /**
     * @var string
     */
    private $_namespace;

    /**
     * Constructor.
     *
     * @param string $directory
     */
    public function __construct(PDO $pdo, $table, $namespace)
    {
        if (strlen($this->_namespace) > self::MAX_NAMESPACE_LENGTH) {
            throw new InvalidArgumentException(
                sprintf(
                    'Length of namespace must be less than or equal to %d bytes',
                    self::MAX_NAMESPACE_LENGTH
                )
            );
        }

        $this->_pdo       = $pdo;
        $this->_table     = $table;
        $this->_namespace = $namespace;
    }

    /**
     * @see Cache_Casual_ContainerInterface::set()
     */
    public function set($key, $value)
    {
        $key = $this->_convertKey($key);

        $sql = 'REPLACE INTO `' . $this->_table . '` ' .
            '(`namespace`, `key`, `content`, `lifetime`, `last_modified`) ' .
            'VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->_pdo->prepare($sql);

        $data = $this->createData($value);

        $stmt->bindValue(1, $this->_namespace, PDO::PARAM_STR);
        $stmt->bindValue(2, $key, PDO::PARAM_STR);
        $stmt->bindValue(3, serialize($data->getContent()), PDO::PARAM_STR);
        $stmt->bindValue(4, $data->getLifetime(), PDO::PARAM_INT);
        $stmt->bindValue(5, $data->getLastModified(), PDO::PARAM_INT);

        $stmt->execute();
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
        $key = $this->_convertKey($key);

        $sql = 'DELETE FROM `' . $this->_table . '` WHERE `namespace` = ? AND `key` = `?` LIMIT 1';
        $stmt = $this->_pdo->prepare($sql);

        $stmt->bindValue(1, $this->_namespace, PDO::PARAM_STR);
        $stmt->bindValue(2, $key, PDO::PARAM_STR);

        $stmt->execute();
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
        $key = $this->_convertKey($key);

        $sql = 'SELECT `namespace`, `key`, `content`, `lifetime`, `last_modified` FROM `' . $this->_table . '` ' .
            'WHERE `namespace` = ? AND `key` = ? LIMIT 1';
        $stmt = $this->_pdo->prepare($sql);

        $stmt->bindValue(1, $this->_namespace, PDO::PARAM_STR);
        $stmt->bindValue(2, $key, PDO::PARAM_STR);

        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            return new Cache_Casual_Data(array(
                'lifetime'      => (int)$data['lifetime'],
                'last_modified' => (int)$data['last_modified'],
                'content'       => unserialize($data['content']),
            ));
        }
    }

    private function _convertKey($key)
    {
        return (strlen($key) > self::MAX_KEY_LENGTH) ? sha1($key) : $key;
    }
}
