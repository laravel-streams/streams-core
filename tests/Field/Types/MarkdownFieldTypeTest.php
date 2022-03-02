<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Value\MarkdownValue;
use Streams\Core\Field\Types\MarkdownFieldType;

class MarkdownFieldTypeTest extends CoreTestCase
{
    public function test_decorated_value()
    {
        $field = new MarkdownFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(MarkdownValue::class, $field->decorate('markdown'));
    }
}
