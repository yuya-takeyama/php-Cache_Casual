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
 * Data object of cached content.
 *
 * @author Yuya Takeyama
 */
class Cache_Casual_Data
{
    /**
     * Lifetime of cached content. (sec)
     *
     * @var int
     */
    protected $_lifetime;

    /**
     * Last modified timestamp of the content.
     *
     * @var int
     */
    protected $_lastModified;

    /**
     * The cached content itself.
     *
     * @var mixed
     */
    protected $_content;

    /**
     * Constructor.
     *
     * @param  array $params
     *               - int   lifetime
     *               - int   last_modified
     *               - mixed content
     */
    public function __construct($params = array())
    {
        $this->_lifetime     = $params['lifetime'];
        $this->_lastModified = $params['last_modified'];
        $this->_content      = $params['content'];
    }

    /**
     * Whether the data's lifetime is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        $now      = $this->_getCurrentTimestamp();
        $expire   = $this->_lastModified + $this->_lifetime;
        return $now >= $expire;
    }

    /**
     * Whether the data's lifetime is *not* expired.
     */
    public function isNotExpired()
    {
        return ! $this->isExpired();
    }

    /**
     * Gets the content.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * Gets the lifetime.
     *
     * @return int
     */
    public function getLifetime()
    {
        return $this->_lifetime;
    }

    /**
     * Gets the last modified time.
     *
     * @return int
     */
    public function getLastModified()
    {
        return $this->_lastModified;
    }

    /**
     * Gets the current timestamp.
     *
     * @return int
     */
    protected function _getCurrentTimestamp()
    {
        return time();
    }
}
