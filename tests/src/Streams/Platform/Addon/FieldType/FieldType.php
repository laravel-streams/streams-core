<?php namespace Streams\Platform\Asset\FieldType;

class FieldTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testItIsAFieldType()
    {
        $addon = $this->stub();

        $this->assertEquals('field_type', $addon->getType());
    }

    public function testItCanReturnNewPresenter()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\FieldType\FieldTypePresenter';
        $actual   = get_class($addon->newPresenter());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanReturnNewServiceProvider()
    {
        $addon = $this->stub();

        $expected = 'Streams\Platform\Addon\FieldType\FieldTypeServiceProvider';
        $actual   = get_class($addon->newServiceProvider());

        $this->assertEquals($expected, $actual);
    }

    protected function stub()
    {
        return new \Streams\Platform\Addon\FieldType\FieldTypeAddon(app());
    }
}
