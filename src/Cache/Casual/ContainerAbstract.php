<?php
/**
 * Cache_Casual.
 */

/**
 * Abstract class of Cache_Casual_Container.
 *
 * @author Yuya Takeyama
 */
abstract class Cache_Casual_ContainerAbstract implements Cache_Casual_ContainerInterface
{
    /**
     * Factory object of Cache_Casual_Data.
     *
     * @var Cache_Casual_DataFactory
     */
    private $_factory;

    /**
     * Sets the factory object of Cache_Casual_Data.
     *
     * @param  Cache_Casual_DataFactory $factory
     * @return void
     */
    public function setDataFactory(Cache_Casual_DataFactory $factory)
    {
        $this->_dataFactory = $factory;
    }

    /**
     * Creates the cached data object.
     *
     * @param  mixed Content of cached data.
     * @return Cache_Casual_Data
     */
    public function createData($content)
    {
        return $this->_dataFactory->create($content);
    }
}
