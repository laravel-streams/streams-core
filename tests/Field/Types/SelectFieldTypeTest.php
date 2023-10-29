<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Schema\SelectSchema;
use Streams\Core\Field\Types\SelectFieldType;
use Streams\Core\Field\Decorator\SelectDecorator;

class SelectFieldTypeTest extends CoreTestCase
{
    public function test_it_supports_enumerated_options()
    {
        $field = new SelectFieldType([
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
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => CallableSelectOptions::class,
            ],
        ]);

        $this->assertSame(['baz' => 'Baz', 'qux' => 'Qux'], $field->options());
    }

    public function test_it_returns_select_decorator()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(SelectDecorator::class, $field->decorate('foo'));
    }

    public function test_it_returns_select_schema()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(SelectSchema::class, $field->schema());
    }

    public function test_it_automates_array_validation()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $this->assertSame(['in:foo,bar', 'nullable'], $field->rules());
    }

    public function test_it_generates_selectable_values()
    {
        $field = new SelectFieldType([
            'config' => [
                'options' => [
                    'foo' => 'Foo',
                    'bar' => 'Bar'
                ],
            ],
        ]);

        $this->assertContains($field->generate(), ['foo', 'bar']);
    }
}

class CallableSelectOptions
{
    public function __invoke()
    {
        return [
            'baz' => 'Baz',
            'qux' => 'Qux',
        ];
    }
}
