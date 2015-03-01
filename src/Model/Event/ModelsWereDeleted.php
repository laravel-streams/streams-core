<?php namespace Anomaly\Streams\Platform\Model\Event;

use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class ModelsWereDeleted
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Model\Event
 */
class ModelsWereDeleted
{

    /**
     * The model object.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new ModelsWereDeleted instance.
     *
     * @param EloquentModel $model
     */
    function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Get the model object.
     *
     * @return EloquentModel
     */
    public function getModel()
    {
        return $this->model;
    }
}
