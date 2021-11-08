<?php

namespace Streams\Core\Field\Value;

use Streams\Core\Support\Facades\Images;

class TemplateValue extends Value
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
