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
 * On-memory cache container.
 *
 * @author Yuya Takeyama
 */
class Cache_Casual_Container_Memory extends Cache_Casual_ContainerAbstract
{
    /**
     * Data storage of cached contents.
     *
     * @var array
     */
    protected $_data = array();

    /**
     * @see Cache_Casual_ContainerInterface::set()
     */
    public function set($key, $value)
    {
        $this->_data[$key] = $this->createData($value);
    }

    /**
     * @see Cache_Casual_ContainerInterface::get()
     */
    public function get($key)
    {
        if ($this->has($key)) {
            return $this->_data[$key]->getContent();
        }
    }

    /**
     * @see Cache_Casual_ContainerInterface::has()
     */
    public function has($key)
    {
        return isset($this->_data[$key]) && $this->_data[$key]->isNotExpired();
    }

    /**
     * @see Cache_Casual_ContainerInterface::delete()
     */
    public function delete($key)
    {
        unset($this->_data[$key]);
    }
}
