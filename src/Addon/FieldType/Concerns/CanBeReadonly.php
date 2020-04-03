<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait CanBeReadonly
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait CanBeReadonly
{

    /**
     * The readonly flag.
     *
     * @var bool
     */
    protected $readonly = false;

    /**
     * Get the readonly flag.
     *
     * @return bool
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * Set the readonly flag.
     *
     * @param $readonly
     * @return $this
     */
    public function setReadonly($readonly)
    {
        $this->readonly = $readonly;

        return $this;
    }
}
