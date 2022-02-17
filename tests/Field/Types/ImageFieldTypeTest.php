<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\Value\ImageValue;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ImageFieldType;

class ImageFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_image_value()
    {
        $field = new ImageFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(ImageValue::class, $field->expand(''));
    }
}
