<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\UrlFieldType;

class UrlDecoratorTest extends CoreTestCase
{
    public function test_it_supports_to_string()
    {
        $field = new  UrlFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate($value = 'https://streams.dev/docs?foo=bar');

        $this->assertSame($value, (string) $decorator);
    }

    public function test_it_parses_urls()
    {
        $field = new  UrlFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('https://streams.dev/docs?foo=bar');

        $this->assertIsArray($decorator->parse());
        $this->assertSame('https', $decorator->parse('scheme'));

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->parse('scheme'));
    }

    public function test_it_returns_query_params()
    {
        $field = new  UrlFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('https://streams.dev/docs?foo=bar');

        $this->assertIsArray($decorator->query());
        $this->assertSame('bar', $decorator->query('foo'));

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->query());
    }

    public function test_it_returns_anchor_links()
    {
        $field = new  UrlFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('https://streams.dev/docs?foo=bar');

        $this->assertStringContainsString('href="https://streams', $decorator->link());
        $this->assertStringContainsString('Visit Website', $decorator->link('Visit Website'));

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->link());
    }

    public function test_it_can_change_paths()
    {
        $field = new  UrlFieldType([
            'stream' => Streams::make('films'),
        ]);

        $decorator = $field->decorate('https://streams.dev/docs?foo=bar');

        $this->assertStringContainsString('.dev/packages', $decorator->to('packages'));

        $decorator = $field->decorate(null);

        $this->assertNull($decorator->to('packages'));
    }
}
