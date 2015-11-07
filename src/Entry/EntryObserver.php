<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\SetMetaInformation;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Entry\Event\EntryWasCreated;
use Anomaly\Streams\Platform\Entry\Event\EntryWasDeleted;
use Anomaly\Streams\Platform\Entry\Event\EntryWasSaved;
use Anomaly\Streams\Platform\Entry\Event\EntryWasUpdated;
use Anomaly\Streams\Platform\Model\Event\ModelsWereDeleted;
use Anomaly\Streams\Platform\Model\Event\ModelsWereUpdated;
use Anomaly\Streams\Platform\Support\Observer;

/**
 * Class EntryObserver
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 *
 * @package Anomaly\Streams\Platform\Entry
 */
class EntryObserver extends Observer
{

    /**
     * Run before a record is created.
     *
     * @param EntryInterface $entry
     */
    public function creating(EntryInterface $entry)
    {
        //$entry->fireFieldTypeEvents('entry_creating');
    }

    /**
     * Run after a record is created.
     *
     * @param EntryInterface $entry
     */
    public function created(EntryInterface $entry)
    {
        $entry->fireFieldTypeEvents('entry_created');

        $this->events->fire(new EntryWasCreated($entry));
    }

    /**
     * Run after a record is updated.
     *
     * @param EntryInterface $entry
     */
    public function updated(EntryInterface $entry)
    {
        $entry->fireFieldTypeEvents('entry_updated');

        $this->events->fire(new EntryWasUpdated($entry));
    }

    /**
     * Before saving an entry touch the
     * meta information.
     *
     * @param  EntryInterface $entry
     * @return bool
     */
    public function saving(EntryInterface $entry)
    {
        //$entry->fireFieldTypeEvents('entry_saving');

        $this->commands->dispatch(new SetMetaInformation($entry));
    }

    /**
     * Run after saving a record.
     *
     * @param EntryInterface $entry
     */
    public function saved(EntryInterface $entry)
    {
        $entry->flushCache();
        $entry->fireFieldTypeEvents('entry_saved');

        $this->events->fire(new EntryWasSaved($entry));
    }

    /**
     * Run after multiple entries have been updated.
     *
     * @param EntryInterface $entry
     */
    public function updatedMultiple(EntryInterface $entry)
    {
        $entry->flushCache();

        $this->events->fire(new ModelsWereUpdated($entry));
    }

    /**
     * Run after a record has been deleted.
     *
     * @param EntryInterface $entry
     */
    public function deleted(EntryInterface $entry)
    {
        $entry->flushCache();
        $entry->fireFieldTypeEvents('entry_deleted');

        /* @var EntryTranslationsModel $translation */
        if ($entry->isTranslatable()) {
            foreach ($entry->getTranslations() as $translation) {
                $translation->delete();
            }
        }

        $this->events->fire(new EntryWasDeleted($entry));
    }

    /**
     * Run after entries records have been deleted.
     *
     * @param EntryInterface $entry
     */
    public function deletedMultiple(EntryInterface $entry)
    {
        $entry->flushCache();

        $this->events->fire(new ModelsWereDeleted($entry));
    }
}
