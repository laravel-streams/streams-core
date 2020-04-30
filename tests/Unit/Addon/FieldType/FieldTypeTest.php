<?php

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Tests\TestCase;

class FieldTypeTest extends TestCase
{
    public function testRules()
    {
        $fieldType = app(FieldTypeCollection::class)->instance('anomaly.field_type.text');

        $this->assertTrue(is_array($fieldType->rules()));
        $this->assertTrue(array_search('bar', $fieldType->rules([
            'foo',
            'bar',
        ])) !== false);
        $this->assertTrue(array_search('bar', $fieldType->mergeRules([
            'foo',
            'bar',
        ])->rules()) !== false);
    }
}
