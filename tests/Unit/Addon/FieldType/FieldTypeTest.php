<?php

class FieldTypeTest extends TestCase
{

    public function testCanAccessPostData()
    {
        $this->post('/', ['test_test_field_en' => 'foo']);
        $fieldType = $this->app->make(\Anomaly\Streams\Platform\Addon\FieldType\FieldType::class);

        $fieldType
            ->setField('test_field')
            ->setPrefix('test_')
            ->setLocale('en');

        $this->assertTrue($fieldType->hasPostedInput());
        $this->assertEquals($fieldType->getInputValue(), 'foo');
        $this->assertEquals($fieldType->getPostValue(), 'foo');
    }

    public function testCanHandleEmptyPostValues()
    {
        $this->post('/');
        $fieldType = $this->app->make(\Anomaly\Streams\Platform\Addon\FieldType\FieldType::class);

        $fieldType
            ->setField('test_field')
            ->setPrefix('test_')
            ->setLocale('en');

        $this->assertFalse($fieldType->hasPostedInput());
        $this->assertNull($fieldType->getInputValue());
        $this->assertNull($fieldType->getPostValue());
    }
}