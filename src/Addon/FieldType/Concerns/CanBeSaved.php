<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait CanBeSaved
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait CanBeSaved
{

    /**
     * The save flag.
     *
     * @var bool
     */
    protected $save = true;

    /**
     * Set the save.
     *
     * @param  $save
     * @return $this
     */
    public function setSave($save)
    {
        $this->save = $save;

        return $this;
    }

    /**
     * Get the save flag.
     *
     * @return string
     */
    public function canSave()
    {
        return $this->save;
    }
}
