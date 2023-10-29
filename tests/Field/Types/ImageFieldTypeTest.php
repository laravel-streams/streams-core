<?php

namespace Streams\Core\Tests\Field\Types;

use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Field\FieldDecorator;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\ImageFieldType;

class ImageFieldTypeTest extends CoreTestCase
{
    public function test_it_returns_image_decorator()
    {
        $field = new ImageFieldType([
            'stream' => Streams::make('films')
        ]);

        $this->assertInstanceOf(FieldDecorator::class, $field->decorate(''));
    }

    public function test_it_generates_image_paths()
    {
        $field = new ImageFieldType();

        $this->assertContains(
            pathinfo($field->generate(), PATHINFO_EXTENSION),
            ['jpg', 'png', 'gif']
        );
    }
}
