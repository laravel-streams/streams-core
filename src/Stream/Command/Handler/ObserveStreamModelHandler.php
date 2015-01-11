<?php namespace Anomaly\Streams\Platform\Stream\Command\Handler;

use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Stream\StreamObserver;

/**
 * Class ObserveStreamModelHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Command
 */
class ObserveStreamModelHandler
{

    /**
     * The stream model.
     *
     * @var StreamModel
     */
    protected $model;

    /**
     * The stream observer.
     *
     * @var StreamObserver
     */
    protected $observer;

    /**
     * Create a new ObserveStreamModelHandler instance.
     *
     * @param StreamModel    $model
     * @param StreamObserver $observer
     */
    function __construct(StreamModel $model, StreamObserver $observer)
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
