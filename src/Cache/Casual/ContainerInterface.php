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
 * Interface of Cache_Casual_Container_***.
 *
 * @author Yuya Takeyama
 */
interface Cache_Casual_ContainerInterface
{
    /**
     * Stores the data into the cache container.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Gets the value from the cache container.
     *
     * Returns NULL if the data is expired.
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Whether the data specified with key exists in the cache container.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key);

    /**
     * Deletes the data from the cache container.
     *
     * @param  string $key
     * @return void
     */
    public function delete($key);
}
