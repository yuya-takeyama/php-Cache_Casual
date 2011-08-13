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
 * Factory of cache data object.
 *
 * @author Yuya Takeyama
 */
class Cache_Casual_DataFactory
{
    /**
     * The default lifetime of the data the factory creates.
     *
     * @var int
     */
    protected $_defaultLifetime;

    /**
     * Constructor.
     *
     * @param array $params
     *              - int lifetime The default lifetime.
     */
    public function __construct($defaultLifetime)
    {
        $this->_defaultLifetime = $defaultLifetime;
    }

    /**
     * Creates the chache data object.
     *
     * @param  mixed The content of the data cached.
     * @return Cache_Casual_Data
     */
    public function create($content)
    {
        return new Cache_Casual_Data(array(
            'lifetime'      => $this->_defaultLifetime,
            'last_modified' => new DateTime,
            'content'       => $content,
        ));
    }
}
