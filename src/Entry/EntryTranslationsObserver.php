<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\SetMetaInformation;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class EntryTranslationsObserver
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryTranslationsObserver extends Observer
{

    /**
     * Before saving an entry touch the
     * meta information.
     *
     * @param  EntryTranslationsModel $entry
     * @return bool
     */
    public function saving(EntryTranslationsModel $entry)
    {
        $this->commands->dispatch(new SetMetaInformation($entry));
    }
}
