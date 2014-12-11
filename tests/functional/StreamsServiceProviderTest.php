<?php namespace Anomaly\Streams\Platform;

class StreamsServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testItCanrRegister()
    {
        $provider = new \Anomaly\Streams\Platform\StreamsServiceProvider(app());

        $provider->register();
    }
}
 