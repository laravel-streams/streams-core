<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\MultiselectValue;
use Streams\Core\Field\Types\MultiselectFieldType;

class MultiselectFieldTypeTest extends CoreTestCase
{
    public function test_it_supports_enumerated_options()
    {
        $field = new MultiselectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $this->assertSame(['foo' => 'Foo', 'bar' => 'Bar'], $field->options());
    }

    public function test_it_supports_callable_options()
    {
        $field = new MultiselectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => CallableMultiselectOptions::class,
            ],
        ]);

        $this->assertSame(['baz' => 'Baz', 'qux' => 'Qux'], $field->options());
    }

    public function test_it_returns_multiselect_value()
    {
        $field = new MultiselectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(MultiselectValue::class, $field->decorate([]));
    }
}

class CallableMultiselectOptions
{
    public function __invoke()
    {
        return [
            'baz' => 'Baz',
            'qux' => 'Qux',
        ];
    }
}
