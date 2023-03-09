<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\StringFieldType;

class StringDecoratorTest extends CoreTestCase
{
    public function test_it_supports_to_string()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('Foo {{ $foo }}');

        $this->assertSame('Foo {{ $foo }}', (string) $decorator);
    }

    public function test_it_renders_strings()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('Foo {{ $foo }}');

        $this->assertSame("Foo Bar", $decorator->render(['foo' => 'Bar']));
    }

    public function test_it_parses_yaml()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate("- foo\n- bar");

        $this->assertSame(2, count($decorator->yaml()));
    }

    public function test_it_parses_markdown()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('# Hello World');

        $this->assertSame("<h1>Hello World</h1>\n", $decorator->markdown());
    }

    public function test_it_parses_strings()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('Foo {foo}');

        $this->assertSame("Foo Bar", $decorator->parse(['foo' => 'Bar']));
    }

    public function test_it_returns_array_of_lines()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate("First\nSecond\nThird");

        $this->assertSame(3, count($decorator->lines()));
    }

    public function test_it_returns_json_decoded_strings()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate(json_encode($data = ['foo' => 'bar']));

        $this->assertSame($data, $decorator->decode(true));
    }

    public function test_it_returns_unserialized_strings()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate(serialize($data = ['foo' => 'bar']));

        $this->assertSame($data, $decorator->unserialize());
    }

    public function test_it_returns_tel_links()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('555-555-5555');

        $this->assertStringContainsString('555-555-5555', $decorator->tel());
        $this->assertStringContainsString('tel:5555555555', $decorator->tel());
        $this->assertStringContainsString('Call Me', $decorator->tel('Call Me'));

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->tel());
    }

    public function test_it_returns_sms_links()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('555-555-5555');

        $this->assertStringContainsString('555-555-5555', $decorator->sms());
        $this->assertStringContainsString('sms:5555555555', $decorator->sms());
        $this->assertStringContainsString('Text Me', $decorator->sms('Text Me'));

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->sms());
    }

    public function test_it_forwards_to_string_utility()
    {
        $field = new  StringFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('This is a test.');

        $this->assertSame('This is a...', $decorator->limit(9));
    }
}
