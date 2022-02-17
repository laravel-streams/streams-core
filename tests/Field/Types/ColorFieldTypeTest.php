<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\ColorValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ColorFieldType;

class ColorFieldTypeTest extends CoreTestCase
{
    public function test_it_forces_lowercase()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('#ffffff', $field->modify('#FFFFFF'));
        $this->assertSame('#ffffff', $field->restore('#FFFFFF'));
    }

    public function test_it_returns_color_value()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ColorValue::class, $field->expand('#ffffff'));
    }
}
