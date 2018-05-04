<?php

use Illuminate\Http\UploadedFile;

class FieldTypeTest extends TestCase
{

    public function testCanAccessPostData()
    {
        $response = $this->post('/', ['test_test_field_en' => 'foo']);
        $fieldType = $this->app->make(\Anomaly\Streams\Platform\Addon\FieldType\FieldType::class);

        $fieldType
            ->setField('test_field')
            ->setPrefix('test_')
            ->setLocale('en');

        $this->assertTrue($fieldType->hasPostedInput());
        $this->assertEquals($fieldType->getInputValue(), 'foo');
        $this->assertEquals($fieldType->getPostValue(), 'foo');
    }

    public function testCanAccessPostFiles()
    {
        $file = UploadedFile::fake('test.jpg', 100);

        $response = $this->post('/', ['test_test_field_en' => $file]);
        $fieldType = $this->app->make(\Anomaly\Streams\Platform\Addon\FieldType\FieldType::class);

        $fieldType
            ->setField('test_field')
            ->setPrefix('test_')
            ->setLocale('en');

        $this->assertTrue($fieldType->hasPostedInput());
        $this->assertEquals($fieldType->getInputValue(), $file);
        $this->assertEquals($fieldType->getPostValue(), $file);
    }

    public function testCanHandleEmptyPostValues()
    {
        $response = $this->post('/');
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
