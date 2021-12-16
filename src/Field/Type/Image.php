<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Value\ImageValue;

class Image extends File
{
    public function getValueName()
    {
        return ImageValue::class;
    }
}
