<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Decorator\ImageDecorator;

class ImageFieldType extends FileFieldType
{
    public function getDecoratorName()
    {
        return ImageDecorator::class;
    }
}
