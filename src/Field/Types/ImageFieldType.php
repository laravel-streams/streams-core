<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Value\ImageValue;

class ImageFieldType extends FileFieldType
{
    public function getValueName()
    {
        return ImageValue::class;
    }
}
