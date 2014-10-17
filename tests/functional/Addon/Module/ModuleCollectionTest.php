<?php namespace Streams\Platform\Addon\Module;

class ModuleCollectionTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testGet()
    {
        $provider = new ModuleServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $collection = app('streams.modules');

        $collection->findBySlug('testable')->setInstalled(true);

        $this->assertEquals(1, count($collection->installed()));

        $collection->findBySlug('testable')->setEnabled(true);

        $this->assertEquals(1, count($collection->enabled()));

        $collection->findBySlug('testable')->setActive(true);

        $this->assertEquals(1, count($collection->active()));
    }
}
 