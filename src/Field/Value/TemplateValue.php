<?php

namespace Anomaly\Streams\Platform\Field\Value;

use Anomaly\Streams\Platform\Support\Facades\Images;

/**
 * Class TemplateValue
 * 
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
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
