<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

class FieldTypeAddonTest extends \PHPUnit_Framework_TestCase
{
    protected static $fieldType;

    public static function setUpBeforeClass()
    {
        $provider = new \Anomaly\Streams\Platform\Provider\AddonServiceProvider(app());

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

    public function testItCanSetLabel()
    {
        $fieldType = self::$fieldType;

        $fieldType->setLabel('Foo');

        $this->assertTrue(true);
    }

    public function testItCanSetInstructions()
    {
        $fieldType = self::$fieldType;

        $fieldType->setInstructions('Foo bar baz');

        $this->assertTrue(true);
    }

    public function testItCanSetSlug()
    {
        $fieldType = self::$fieldType;

        $fieldType->setSlug('foo');

        $this->assertTrue(true);
    }

    public function testItCanSetLocale()
    {
        $fieldType = self::$fieldType;

        $fieldType->setLocale('fr');

        $this->assertTrue(true);
    }

    public function testItCanSetPrefix()
    {
        $fieldType = self::$fieldType;

        $fieldType->setPrefix('foo');

        $this->assertTrue(true);
    }

    public function testItCanGetFieldName()
    {
        $fieldType = self::$fieldType;

        $fieldType->setPrefix('foo')->setSlug('bar')->setLocale('fr');

        $this->assertEquals('foo-bar-fr', $fieldType->getFieldName());
    }

    public function testItCanGetColumnName()
    {
        $fieldType = self::$fieldType;

        $this->assertEquals('foo', $fieldType->setSlug('foo')->getColumnName());
    }

    public function testItCanGetColumnType()
    {
        $fieldType = self::$fieldType;

        $this->assertEquals('string', $fieldType->getColumnType());
    }

    public function testItCanReturnInput()
    {
        $fieldType = self::$fieldType;

        $fieldType->setPrefix('foo')->setSlug('bar')->setLocale('fr');

        $expected = '5ae8ea58e6de09f45828ee878056f0cd';
        $actual   = md5($fieldType->input());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnElement()
    {
        $fieldType = self::$fieldType;

        $fieldType
            ->setPrefix('foo')
            ->setSlug('bar')
            ->setLocale('fr')
            ->setLabel('Foo')
            ->setInstructions('Foo instructions.');

        $expected = '011e279e5f0137bf4f97ceca29e4e751';
        $actual   = md5($fieldType->element());

        $this->assertEquals($expected, $actual);
    }

    /**
     * Put these in a common test class in Addon/
     */
    public function testItCanGetPath()
    {
        $fieldType = self::$fieldType;

        $this->assertNotNull($fieldType->getPath());
        $this->assertStringEndsWith('foo/bar', $fieldType->getPath('foo/bar'));
    }

    public function testItCanGetCoreFlag()
    {
        $fieldType = self::$fieldType;

        $this->assertFalse($fieldType->isCore());
    }
}
 