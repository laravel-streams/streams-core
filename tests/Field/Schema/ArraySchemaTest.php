<?php

namespace Streams\Core\Tests\Field\Schema;

use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Schema\ArraySchema;
use Streams\Core\Field\Types\ArrayFieldType;
use Streams\Core\Field\Decorator\ArrayDecorator;

class ArraySchemaTest extends CoreTestCase
{
    public function test_it_returns_schema_type()
    {
        $field = new ArrayFieldType([
            'stream' => 'films',
        ]);

        $this->assertSame('{"type":"array"}', $field->schema()->type()->toJson());
    }

    public function test_it_supports_min_and_max()
    {
        $field = new ArrayFieldType([
            'handle' => 'title',
            'stream' => 'films',
            'rules' => [
                'min:1',
                'max:3',
            ],
        ]);

        $this->assertSame(
            '{"title":"Title","type":"array","maxItems":3,"minItems":1}',
            $field->schema()->property()->toJson()
        );
    }

    public function test_it_supports_unique()
    {
        $field = new ArrayFieldType([
            'handle' => 'title',
            'stream' => 'films',
            'rules' => [
                'unique',
            ],
        ]);

        $this->assertSame(
            '{"title":"Title","type":"array","uniqueItems":true}',
            $field->schema()->property()->toJson()
        );
    }
    
    public function test_it_supports_item_limitations()
    {
        $field = new ArrayFieldType([
            'handle' => 'title',
            'stream' => 'films',
            'config' => [
                'items' => [
                    ['type' => 'string'],
                    ['type' => 'integer'],
                ],
            ],
        ]);

        $this->assertSame(
            '{"title":"Title","type":"array","items":{"anyOf":[{"type":"string"},{"type":"integer"}]}}',
            $field->schema()->property()->toJson()
        );
    }
}
