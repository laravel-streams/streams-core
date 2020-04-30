<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasPrefix
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasPrefix
{

    /**
     * The field's input prefix.
     *
     * @var null|string
     */
    public $prefix = null;

    /**
     * Set the prefix.
     *
     * @param  $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }
}
