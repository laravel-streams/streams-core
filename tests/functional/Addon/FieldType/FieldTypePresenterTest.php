<?php namespace Streams\Platform\Addon\FieldType;

class FieldTypePresenterTest extends \PHPUnit_Framework_TestCase
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

    public function testItReturnsGetValueForToStringMethod()
    {
        $fieldType = self::$fieldType;

        $fieldType->setValue('foo');

        $this->assertEquals('foo', (string)$fieldType);
    }

    /**
     * Put this in \Addon
     */
    public function testItsPresenterCanReturnNameAndDescription()
    {
        $fieldType = self::$fieldType;

        $this->assertEquals('field_type.testable::addon.name', $fieldType->name);
        $this->assertEquals('field_type.testable::addon.description', $fieldType->description);
    }
}
 