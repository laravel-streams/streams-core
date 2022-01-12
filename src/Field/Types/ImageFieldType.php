<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Value\ImageValue;

class Image extends File
{
    public function getValueName()
    {
        return ImageValue::class;
    }
}
