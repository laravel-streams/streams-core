<?php

namespace Anomaly\Streams\Platform\Field\Value;

/**
 * Class Value
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Value
{

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
}
