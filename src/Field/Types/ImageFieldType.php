<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Presenter\ImagePresenter;

class ImageFieldType extends FileFieldType
{
    public function getPresenterName()
    {
        return ImagePresenter::class;
    }
}
