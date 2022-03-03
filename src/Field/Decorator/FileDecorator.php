<?php

namespace Streams\Core\Field\Decorator;

use Streams\Core\Image\Image;
use Streams\Core\Field\FieldDecorator;
use Streams\Core\Support\Facades\Images;

class FileDecorator extends FieldDecorator
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
