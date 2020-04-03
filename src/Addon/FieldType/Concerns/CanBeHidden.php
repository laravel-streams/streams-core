<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait CanBeHidden
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait CanBeHidden
{

    /**
     * The hidden flag.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * Set the hidden flag.
     *
     * @param  $hidden
     * @return $this
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get the hidden flag.
     *
     * @return bool
     */
    public function isHidden()
    {
        return ($this->hidden);
    }
}
