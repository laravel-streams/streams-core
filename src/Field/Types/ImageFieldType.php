<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;

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
}
