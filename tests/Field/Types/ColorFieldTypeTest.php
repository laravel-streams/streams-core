<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Schema\StringSchema;
use Streams\Core\Field\Types\ColorFieldType;
use Streams\Core\Field\Decorator\ColorDecorator;

class ColorFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_default_rules()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertContains('valid_color', array_keys($field->rules()));
    }

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

    public function test_it_returns_color_schemma()
    {
        $field = new ColorFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(StringSchema::class, $field->schema());
    }

    public function test_it_validates_values()
    {
        $stream = Streams::build([
            'id' => 'tmp',
            'fields' => [
                [
                    'handle' => 'color',
                    'type' => 'color',
                ],
            ],
        ]);

        $field = $stream->fields->get('color');

        $data = 'Test';

        $this->assertFalse($field->validator($data)->passes());

        $data = '#209E49';

        $this->assertTrue($field->validator($data)->passes());
        
        $data = 'rgb(32, 158, 73)';

        $this->assertTrue($field->validator($data)->passes());
    }
}
