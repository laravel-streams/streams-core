<?php namespace Anomaly\Streams\Platform\Model\Command;

use Anomaly\Streams\Platform\Model\EloquentCollection;
use Anomaly\Streams\Platform\Model\EloquentModel;

/**
 * Class Cascade
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Cascade
{

    /**
     * The eloquent model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * The cascading action.
     *
     * @var string
     */
    protected $action;

    /**
     * Create a new Cascade instance.
     *
     * @param EloquentModel $model
     * @param               $action
     */
    public function __construct(EloquentModel $model, $action)
    {
        $this->model  = $model;
        $this->action = $action;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        foreach ($this->model->getCascades() as $relation => $actions) {
            if (in_array($this->action, $actions)) {

                $relation = $this->model->{$relation};

                if ($relation instanceof EloquentModel) {
                    $relation->{$this->action}();
                }

                if ($relation instanceof EloquentCollection) {
                    $relation->each(
                        function (EloquentModel $item) {
                            $item->{$this->action}();
                        }
                    );
                }
            }
        }
    }
}
