<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Value\ImageValue;

class ImageFieldType extends FileFieldType
{
    public function getPresenterName()
    {
        return ImageValue::class;
    }
}
