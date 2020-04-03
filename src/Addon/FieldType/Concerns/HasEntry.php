<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait HasEntry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasEntry
{

    /**
     * The contextual entry.
     *
     * @var mixed
     */
    protected $entry = null;

    /**
     * Get the entry.
     *
     * @return mixed
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }
}
