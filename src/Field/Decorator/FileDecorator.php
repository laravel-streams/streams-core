<?php

namespace Streams\Core\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Field\FieldDecorator;
use Streams\Core\Support\Facades\Images;

class FileDecorator extends FieldDecorator
{
    public function image(): Image
    {
        return Images::make($this->value);
    }
}
