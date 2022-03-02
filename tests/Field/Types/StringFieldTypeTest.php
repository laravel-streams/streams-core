<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\StringFieldType;
use Streams\Core\Field\Decorator\StringDecorator;

class StringFieldTypeTest extends CoreTestCase
{
    public function test_casts_to_string()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('100', $field->modify(100));
        $this->assertSame('100', $field->restore(100));
    }

    public function test_it_returns_string_value()
    {
        $field = new StringFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringDecorator::class, $field->decorate('example'));
    }
}
