<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\SelectFieldType;
use Streams\Core\Field\Presenter\SelectPresenter;

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

    public function test_it_returns_select_value()
    {
        $field = new SelectFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(SelectPresenter::class, $field->decorate('foo'));
    }

    public function test_it_configures_validation()
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

        $this->assertStringContainsString('foo', $field->rules()[0]);
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
