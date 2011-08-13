<?php
/**
 * Cache_Casual.
 */

/**
 * Interface of Cache_Casual_Container.
 *
 * @author Yuya Takeyama
 */
interface Cache_Casual_ContainerInterface
{
    /**
     * Stores the value to the container.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value);

    /**
     * Gets the value from the cached data.
     *
     * Returns NULL if the data is expired.
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Whether the data specified with $key exists in the container.
     *
     * @param  string $key
     * @return bool
     */
    public function has($key);

    /**
     * Deletes the data from the container.
     *
     * @param  string $key
     * @return void
     */
    public function delete($key);
}
