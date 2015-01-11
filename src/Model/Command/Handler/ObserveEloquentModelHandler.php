<?php namespace Anomaly\Streams\Platform\Model\Command\Handler;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Model\EloquentObserver;

/**
 * Class ObserveEloquentModelHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Command
 */
class ObserveEloquentModelHandler
{

    /**
     * The eloquent model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * The eloquent observer.
     *
     * @var EloquentObserver
     */
    protected $observer;

    /**
     * Create a new ObserveEloquentModelHandler instance.
     *
     * @param EloquentModel    $model
     * @param EloquentObserver $observer
     */
    function __construct(EloquentModel $model, EloquentObserver $observer)
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
