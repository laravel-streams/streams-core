<?php namespace Anomaly\Streams\Platform\Assignment\Command\Handler;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Assignment\AssignmentObserver;

/**
 * Class ObserveAssignmentModelHandler
 *
 * @link          http://anomaly.is/assignments-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Command
 */
class ObserveAssignmentModelHandler
{

    /**
     * The assignment model.
     *
     * @var AssignmentModel
     */
    protected $model;

    /**
     * The assignment observer.
     *
     * @var AssignmentObserver
     */
    protected $observer;

    /**
     * Create a new ObserveAssignmentModelHandler instance.
     *
     * @param AssignmentModel    $model
     * @param AssignmentObserver $observer
     */
    function __construct(AssignmentModel $model, AssignmentObserver $observer)
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
