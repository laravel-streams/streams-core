<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasCastType
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasCastType
{

    /**
     * The cast type.
     *
     * @var string
     */
    public $castType = null;

    /**
     * Get the cast type.
     *
     * @return string
     */
    public function getCastType()
    {
        return $this->castType;
    }

    /**
     * Set the cast type.
     *
     * @param $castType
     * @return $this
     */
    public function setCastType($castType)
    {
        $this->castType = $castType;

        return $this;
    }
}
