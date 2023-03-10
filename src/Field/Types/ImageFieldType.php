<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Decorator\ImageDecorator;

class ImageFieldType extends FileFieldType
{
    public function generator()
    {
        return function () {

            $file = Str::uuid();
            $directory = 'img/';
            $extension = fake()->randomElement(['jpg', 'png', 'gif']);

            return "$directory/$file.$extension";
        };
    }

    public function getDecoratorName()
    {
        return ImageDecorator::class;
    }
}
