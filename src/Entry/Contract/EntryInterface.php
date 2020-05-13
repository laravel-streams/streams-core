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
     * Return the entry stream.
     *
     * @var Stream
     */
    public function stream();

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();

    /**
     * Convert the object to
     * its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0);
}
