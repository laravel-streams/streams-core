<?php

namespace Streams\Core\Tests\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Tests\CoreTestCase;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Types\FileFieldType;

class FileDecoratorTest extends CoreTestCase
{
    public function test_it_returns_image_instances()
    {
        $field = new FileFieldType([
            'stream' => Streams::make('films')
        ]);

        $decorator = $field->decorate('local://img/example.jpg');

        $this->assertInstanceOf(Image::class, $decorator->image());
    }
}
