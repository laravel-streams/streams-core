<?php

class StreamsServiceProviderTest extends TestCase
{

    public function testRegistersSingletonOfComposerJson()
    {
        $this->assertTrue(isset(app('composer.json')['require']['anomaly/streams-platform']));
    }

    public function testRegistersSingletonOfComposerLock()
    {
        $this->assertTrue(isset(app('composer.lock')['packages']));
    }
}
