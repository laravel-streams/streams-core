<?php

namespace Anomaly\Streams\Platform\Entry\Contract;

use Anomaly\Streams\Platform\Stream\Stream;

/**
 * Interface EntryInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface EntryInterface
{

    /**
     * Return the Stream definition.
     *
     * @var Stream
     */
    public function stream();

    /**
     * Return the entry attributes.
     *
     * @var array
     */
    public function getAttributes();

    /**
     * Save the entry.
     * 
     * @var bool
     */
    public function save();
}
