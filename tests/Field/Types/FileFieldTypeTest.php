<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\FileValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\FileFieldType;

class FileFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_file_value()
    {
        $field = new FileFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(FileValue::class, $field->expand(''));
    }
}
