<?php

namespace Anomaly\Streams\Platform\Model\Command;

use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Message\Facades\Messages;

/**
 * Class RestrictDelete
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RestrictDelete
{

    /**
     * The eloquent model.
     *
     * @var Model
     */
    protected $model;

    /**
     * Create a new RestrictDelete instance.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Handle the command.
     *
     *
     * @return bool
     */
    public function handle()
    {
        // foreach ($this->model->getRestricts() as $relation) {
        //     $humanize = humanize($relation);

        //     /* @var Relation $relation */
        //     $relation = $this->model->{$relation}();

        //     if (method_exists($relation, 'withTrashed')) {
        //         $relation = $relation->withTrashed();
        //     }

        //     if ($relation->count()) {
        //         Messages::warning(
        //             trans(
        //                 'streams::message.delete_restrict',
        //                 [
        //                     'relation' => $humanize,
        //                     'name'     => $this->model->getTitle(),
        //                 ]
        //             )
        //         );

        //         return true;
        //     };
        // }

        return false;
    }
}
