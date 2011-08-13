<?php
/**
 * Test class for Cache_Casual_Data.
 */
class Cache_Casual_DataTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function getContent_should_be_the_data_set_by_constructor()
    {
        $input = $expected = 'Foo';
        $data = $this->createDataWithContent($input);
        $this->assertSame($expected, $data->getContent());
    }

    /**
     * @test
     */
    public function getContent_should_be_able_to_return_complex_data_structure()
    {
        $input = $expected = array('foo' => 'bar', 'hoge' => array('fuga'));
        $data = $this->createDataWithContent($input);
        $this->assertSame($expected, $data->getContent());
    }

    /**
     * @test
     */
    public function isExpired_should_be_true_if_the_data_is_expired()
    {
        $data = $this->createDataWithLifetime(0);
        $this->assertTrue($data->isExpired());
    }

    /**
     * @test
     */
    public function isExpired_should_be_false_if_the_data_is_not_expired()
    {
        $data = $this->createDataWithLifetime(3600);
        $this->assertFalse($data->isExpired());
    }

    /**
     * @test
     */
    public function getLifetime_should_be_the_value_set_by_constructor()
    {
        $input = $expected = 1234;
        $data = $this->createDataWithLifetime($input);
        $this->assertSame($expected, $data->getLifetime());
    }

    /**
     * Creation method of Cache_Casual_Data with content.
     *
     * @param  mixed $content
     * @return Cache_Casual_Data
     */
    protected function createDataWithContent($content)
    {
        return new Cache_Casual_Data(array(
            'lifetime'      => 3600,
            'last_modified' => new DateTime,
            'content'       => $content,
        ));
    }

    /**
     * Creation method of Cache_Casual_Data with lifetime.
     *
     * @var int $lifetime
     */
    protected function createDataWithLifetime($lifetime)
    {
        return new Cache_Casual_Data(array(
            'lifetime'      => $lifetime,
            'last_modified' => new DateTime,
            'content'       => 'foo',
        ));
    }
}
