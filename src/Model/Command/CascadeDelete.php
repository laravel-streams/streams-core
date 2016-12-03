<?php namespace Anomaly\Streams\Platform\Model\Command;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class CascadeDelete
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CascadeDelete
{

    /**
     * The eloquent model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new CascadeDelete instance.
     *
     * @param EloquentModel $model
     */
    public function __construct(EloquentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $action = $this->model->isForceDeleting() ? 'forceDelete' : 'delete';

        foreach ($this->model->getCascades() as $relation => $actions) {
            if (in_array($action, $actions)) {

                $relation = $this->model->{$relation};

                if ($relation instanceof EloquentModel) {
                    $relation->{$action}();
                }

                if ($relation instanceof EloquentCollection) {
                    $relation->each(
                        function (EloquentModel $item) use ($action) {
                            $item->{$action}();
                        }
                    );
                }
            }
        }
    }
}
