<?php namespace Anomaly\Streams\Platform\Field\Command\Handler;

use Anomaly\Streams\Platform\Field\FieldModel;
use Anomaly\Streams\Platform\Field\FieldObserver;

/**
 * Class ObserveFieldModelHandler
 *
 * @link          http://anomaly.is/assignments-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Command
 */
class ObserveFieldModelHandler
{

    /**
     * The assignment model.
     *
     * @var FieldModel
     */
    protected $model;

    /**
     * The assignment observer.
     *
     * @var FieldObserver
     */
    protected $observer;

    /**
     * Create a new ObserveFieldModelHandler instance.
     *
     * @param FieldModel    $model
     * @param FieldObserver $observer
     */
    function __construct(FieldModel $model, FieldObserver $observer)
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
