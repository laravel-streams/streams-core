<?php

namespace Anomaly\Streams\Platform\Field\Value;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;

/**
 * Class Value
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Value
{

    use Macroable;
    use ForwardsCalls;

    /**
     * The value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Create a new class instance.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
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
        return $this->forwardCallTo($this->value, $method, $parameters);
    }

    /**
     * Return the string value.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->value);
    }
}
