<?php

namespace Streams\Core\Field\Presenter;

use Streams\Core\Support\Facades\Images;

class ImagePresenter extends FieldPresenter
{

    /**
     * Return an image instance.
     */
    public function make()
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
