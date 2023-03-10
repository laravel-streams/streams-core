<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\MultiselectFieldType;
use Streams\Core\Field\Decorator\MultiselectDecorator;

class MultiselectFieldTypeTest extends CoreTestCase
{
    public function test_it_casts_to_array()
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

        $this->assertSame(['foo'], $field->cast('foo'));
        $this->assertSame(['foo'], $field->cast(['foo']));
        $this->assertSame(['foo'], $field->modify('foo'));
        $this->assertSame(['foo'], $field->restore('foo'));
        $this->assertSame(['foo'], $field->restore(['foo']));
    }

    public function test_it_restores_from_json_string()
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

        $this->assertSame(['foo'], $field->restore(json_encode(['foo'])));
    }

    public function test_it_restores_from_serialized_string()
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

        $this->assertSame(['foo'], $field->restore(serialize(['foo'])));
    }

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

    public function test_it_returns_multiselect_decorator()
    {
        $field = new MultiselectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(MultiselectDecorator::class, $field->decorate([]));
    }

    public function test_it_automates_array_validation()
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

        $this->assertSame(['in:foo,bar'], $field->rules());
    }

    public function test_it_generates_integer_values()
    {
        $field = new MultiselectFieldType();

        $this->assertIsArray($field->generate());
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
