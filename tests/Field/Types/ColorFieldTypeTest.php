<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ColorFieldType;
use Streams\Core\Field\Decorator\ColorDecorator;

class ColorFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_lowercase()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertSame('#ffffff', $field->cast('#FFFFFF'));
        $this->assertSame('#ffffff', $field->modify('#FFFFFF'));
        $this->assertSame('#ffffff', $field->restore('#FFFFFF'));
    }

    public function test_it_returns_color_decorator()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ColorDecorator::class, $field->decorate('#ffffff'));
    }
}
