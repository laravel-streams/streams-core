<?php namespace Streams\Platform\Addon\FieldType;

class FieldTypeServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $provider = new \Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();
    }

    public function testItRegistersFieldTypesToContainer()
    {
        $provider = new FieldTypeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Platform\Addon\FieldType\FieldTypePresenter';
        $actual   = app('streams.field_type.testable');

        $this->assertInstanceOf($expected, $actual);
    }

    public function testItPushesFieldTypesToCollection()
    {
        $provider = new FieldTypeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        $expected = 'Streams\Platform\Addon\FieldType\FieldTypePresenter';
        $actual   = app('streams.field_types')->findBySlug('testable');

        $this->assertInstanceOf($expected, $actual);
    }
}
 