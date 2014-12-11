<?php namespace Anomaly\Streams\Platform\Addon\Extension;

class ExtensionCollectionTest extends \PHPUnit_Framework_TestCase
{

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testGet()
    {
        $provider = new ExtensionServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $collection = app('streams.extensions');

        $this->assertEquals(1, count($collection->find('module.testable::*')));

        $this->assertEquals(1, count($collection->find('module.testable::extension.*')));
        $this->assertEquals(0, count($collection->find('module.testable::extensionzzzzzzz.*')));

        $this->assertEquals(1, count($collection->find('module.testable::extension.test')));
        $this->assertEquals(0, count($collection->find('module.testable::extension.nope')));
    }
}
 