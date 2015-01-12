<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;

/**
 * Class SetMetaInformation
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class SetMetaInformation
{

    /**
     * The entry object.
     *
     * @var EntryModel
     */
    protected $entry;

    /**
     * Create a new SetMetaInformation instance.
     *
     * @param EntryModel $entry
     */
    public function __construct(EntryModel $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Get the entry object.
     *
     * @return EntryModel
     */
    public function getEntry()
    {
        return $this->entry;
    }
}
