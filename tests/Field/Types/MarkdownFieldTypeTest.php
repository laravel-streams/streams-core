<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\MarkdownFieldType;
use Streams\Core\Field\Decorator\MarkdownDecorator;

class MarkdownFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_markdown_decorator()
    {
        $field = new MarkdownFieldType([
            'stream' => Streams::make('films'),
        ]);

        $this->assertInstanceOf(MarkdownDecorator::class, $field->decorate('markdown'));
    }
}
