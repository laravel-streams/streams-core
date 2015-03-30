<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Entry\Command\SetMetaInformation;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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
     * Before saving an entry touch the
     * meta information.
     *
     * @param  EntryInterface $model
     * @return bool
     */
    public function saving(EntryInterface $model)
    {
        $this->commands->dispatch(new SetMetaInformation($model));
    }

    /**
     * Run after a record is created.
     *
     * @param EntryInterface $model
     */
    public function created(EntryInterface $model)
    {
        $model->flushCache();
    }

    /**
     * Run after saving a record.
     *
     * @param EntryInterface $model
     */
    public function saved(EntryInterface $model)
    {
        $model->flushCache();
    }

    /**
     * Run after a record has been deleted.
     *
     * @param EntryInterface $model
     */
    public function deleted(EntryInterface $model)
    {
        $model->flushCache();
    }
}
