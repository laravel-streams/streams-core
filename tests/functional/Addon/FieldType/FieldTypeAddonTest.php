<?php namespace Streams\Platform\Addon\FieldType;

class FieldTypeAddonTest extends \PHPUnit_Framework_TestCase
{
    protected static $fieldType;

    public static function setUpBeforeClass()
    {
        $provider = new \Streams\Platform\Provider\AddonServiceProvider(app());

        $provider->register();

        $provider = new FieldTypeServiceProvider(app());

        $provider->addLocation(__DIR__ . '/../../../../tests/addons');

        $provider->register();

        self::$fieldType = app('streams.field_type.testable');
    }

    public function testItCanSetAndGetValue()
    {
        $fieldType = self::$fieldType;

        $this->assertEquals('foo', $fieldType->setValue('foo')->getValue());
    }
}
 