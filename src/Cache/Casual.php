<?php
/**
 * Cache_Casual
 */

require_once dirname(__FILE__) . '/Casual/Data.php';
require_once dirname(__FILE__) . '/Casual/DataFactory.php';
require_once dirname(__FILE__) . '/Casual/ContainerInterface.php';
require_once dirname(__FILE__) . '/Casual/ContainerAbstract.php';

/**
 * Cache_Casual core.
 *
 * @author Yuya Takeyama
 */
class Cache_Casual implements ArrayAccess
{
    /**
     * Constructor.
     *
     * @param Cache_Casual_ContainerInterface $container Cache container object.
     * @param int $lifetime Lifetime of the cached data.
     */
    public function __construct(Cache_Casual_ContainerInterface $container, $lifetime = 3600)
    {
        $this->_container = $container;
        $dataFactory = new Cache_Casual_DataFactory($lifetime);
        $this->_container->setDataFactory($dataFactory);
    }

    /**
     * Sotres the data into the cache container.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->_container->set($key, $value);
    }

    /**
     * Gets the data from the cache container.
     *
     * Returns NULL if the data is expired.
     *
     * @param  string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->_container->get($key);
    }

    /**
     * Whether the data specified with key exists.
     *
     * @param  string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->_container->has($key);
    }

    /**
     * Deletes the data from the cache container.
     *
     * @param  string $key
     * @return void
     */
    public function offsetUnset($key)
    {
        $this->_container->delete($key);
    }
}
