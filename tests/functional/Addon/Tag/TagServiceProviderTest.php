<?php namespace Anomaly\Streams\Platform\Addon\Tag;

class TagServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersTagsToContainer()
    {
        $provider = new PluginServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Anomaly\Streams\Platform\Addon\Tag\TagPresenter';
        $actual   = app('streams.tag.testable');

        $this->assertInstanceOf($expected, $actual);
    }
}
 