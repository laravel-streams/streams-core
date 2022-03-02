<?php

namespace Streams\Core\Field\Presenter;

use Streams\Core\Image\Image;
use Streams\Core\Field\FieldPresenter;
use Streams\Core\Support\Facades\Images;

class FilePresenter extends FieldPresenter
{
    public function make(): Image
    {
        return Images::make($this->value);
    }

    /**
     * Forward calls to the repository.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->forwardCallTo($this->make(), $method, $parameters);
    }
}
