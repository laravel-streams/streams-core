<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasInputType
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasInputType
{

    /**
     * The input type.
     *
     * @var string
     */
    protected $inputType = null;

    /**
     * Get the input type.
     *
     * @return string
     */
    public function getInputType()
    {
        return $this->inputType;
    }
}
