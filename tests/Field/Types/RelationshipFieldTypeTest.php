<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Entry\Entry;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\RelationshipFieldType;

class RelationshipFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_file_value()
    {
        $field = new RelationshipFieldType([
            'stream' => Streams::make('films'),
            'config' => [
                'related' => 'films',
            ]
        ]);

        $this->assertInstanceOf(Entry::class, $field->expand('4'));
    }
}
