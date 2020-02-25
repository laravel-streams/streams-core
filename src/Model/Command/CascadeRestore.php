<?php namespace Anomaly\Streams\Platform\Model\Command;


use Anomaly\Streams\Platform\Model\EloquentModel;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CascadeRestore
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CascadeRestore
{

    /**
     * The eloquent model.
     *
     * @var EloquentModel
     */
    protected $model;

    /**
     * Create a new CascadeRestore instance.
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
        foreach ($this->model->getCascades() as $relation) {
            $relation = $this->model
                ->{camel_case($relation)}()
                ->onlyTrashed()
                ->getResults();

            if ($relation instanceof EloquentModel) {
                $relation->restore();
            }

            if ($relation instanceof Collection) {
                $relation->each(
                    function (EloquentModel $item) {
                        $item->restore();
                    }
                );
            }
        }
    }
}
