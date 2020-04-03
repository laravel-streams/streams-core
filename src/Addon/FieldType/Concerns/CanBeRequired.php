<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait CanBeRequired
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait CanBeRequired
{

    /**
     * The required flag.
     *
     * @var bool
     */
    protected $required = false;

    /**
     * Set the required flag.
     *
     * @param  $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Get the required flag.
     *
     * @return bool
     */
    public function isRequired()
    {
        return ($this->required);
    }
}
