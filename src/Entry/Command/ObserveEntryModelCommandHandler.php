<?php namespace Anomaly\Streams\Platform\Entry\Command;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Entry\EntryObserver;

/**
 * Class ObserveEntryModelCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Command
 */
class ObserveEntryModelCommandHandler
{

    /**
     * The entry model.
     *
     * @var EntryModel
     */
    protected $model;

    /**
     * The entry observer.
     *
     * @var EntryObserver
     */
    protected $observer;

    /**
     * Create a new ObserveEntryModelCommandHandler instance.
     *
     * @param EntryModel    $model
     * @param EntryObserver $observer
     */
    function __construct(EntryModel $model, EntryObserver $observer)
    {
        $this->model    = $model;
        $this->observer = $observer;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $model = $this->model;

        $model::observe($this->observer);
    }
}
