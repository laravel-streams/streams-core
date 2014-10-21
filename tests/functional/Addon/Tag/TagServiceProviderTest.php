<?php namespace Anomaly\Streams\Platform\Addon\Tag;

use Anomaly\Streams\Platform\Addon\Theme\ThemeServiceProvider;

class TagServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersTagsToContainer()
    {
        $provider = new TagServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Anomaly\Streams\Platform\Addon\Tag\TagPresenter';
        $actual   = app('streams.tag.testable');

        $this->assertInstanceOf($expected, $actual);
    }
}
 