<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasWarning
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasWarning
{

    /**
     * The field warning.
     *
     * @var null|string
     */
    protected $warning = null;

    /**
     * Set the warning.
     *
     * @param $warning
     * @return $this
     */
    public function setWarning($warning)
    {
        $this->warning = $warning;

        return $this;
    }

    /**
     * Get the warning.
     *
     * @return null|string
     */
    public function getWarning()
    {
        return $this->warning;
    }
}
