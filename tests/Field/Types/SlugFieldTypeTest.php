<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\StringValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\SlugFieldType;

class SlugFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_slug_string()
    {
        $field = new SlugFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'type' => '_',
            ],
        ]);

        $this->assertSame('test_slug', $field->modify('Test Slug'));
        $this->assertSame('test_slug', $field->restore('Test Slug'));
    }

    public function test_it_returns_string_value()
    {
        $field = new SlugFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringValue::class, $field->decorate('example'));
    }
}
