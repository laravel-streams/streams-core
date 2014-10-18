<?php namespace Streams\Platform\Addon\Theme;

class ThemeCollectionTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testGet()
    {
        $provider = new ThemeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $collection = app('streams.themes');

        $collection->findBySlug('testable')->setActive(true);

        $this->assertEquals(1, count($collection->active()));
    }
}
 