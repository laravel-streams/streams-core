<?php


/**
 * Class StreamsServiceProviderTest
 */
class StreamsServiceProviderTest extends StreamsTestCase
{
    public function testBindsApplicationToDefaultApplication()
    {
        $this->assertEquals("default", resolve("streams.application")->handle);
    }

    public function testBindsApplicationOriginToDefaultApplication()
    {
        $this->assertEquals("default", resolve("streams.application.origin")->handle);
    }

    public function testBindsApplicationHandleToDefault()
    {
        $this->assertEquals("default", resolve("streams.application.handle"));
    }

    public function testBindsParserDataCorrectly()
    {
        request()->merge(['hello' => 'test']);
        $this->assertEquals(['hello' => 'test'], resolve('streams.parser_data')['request']['input']);
    }
}
