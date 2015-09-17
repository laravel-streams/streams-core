<?php

namespace Anomaly\Streams\Platform\Entry\Event;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;

/**
 * Class EntryWasDeleted.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Event
 */
class EntryWasDeleted
{
    /**
     * The entry object.
     *
     * @var EntryInterface
     */
    protected $entry;

    /**
     * Create a new EntryWasDeleted instance.
     *
     * @param EntryInterface $entry
     */
    public function __construct(EntryInterface $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Get the entry.
     *
     * @return EntryInterface
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
