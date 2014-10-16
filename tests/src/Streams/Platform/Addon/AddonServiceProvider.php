<?php namespace Streams\Platform\Asset;

class AddonServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testItCanAddLocation()
    {
        $provider = $this->stub();

        $provider->addLocation('phpunit', __DIR__ . '/../../../../addons');

        $this->assertTrue(true);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\AddonServiceProvider(app());
    }
}
