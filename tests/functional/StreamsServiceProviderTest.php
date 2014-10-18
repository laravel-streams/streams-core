<?php namespace Streams\Platform;

class StreamsServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanrRegister()
    {
        $provider = new \Streams\Platform\StreamsServiceProvider(app());

        $provider->register();
    }
}
 