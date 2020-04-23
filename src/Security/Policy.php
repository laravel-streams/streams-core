<?php

namespace Anomaly\Streams\Platform\Security;

use Illuminate\Support\Facades\Gate;

/**
 * Class Policy
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Policy
{
    /**
     * Determine whether the user can view any anomaly users module user user models.
     *
     * @param $user
     * @return mixed
     */
    public function viewAny($user)
    {
        return true; // @todo remove
    }

    /**
     * Determine whether the user can view the anomaly users module user user model.
     *
     * @param $user
     * @param $model
     * @return mixed
     */
    public function view($user, $model)
    {
        return true; // @todo remove
    }

    /**
     * Determine whether the user can create anomaly users module user user models.
     *
     * @param $user
     * @return mixed
     */
    public function create($user)
    {
        return true; // @todo remove
    }

    /**
     * Determine whether the user can update the anomaly users module user user model.
     *
     * @param $user
     * @param $model
     * @return mixed
     */
    public function update($user, $model)
    {
        // Check security providers.
        if (Gate::has($model->stream()->slug . '.update', $model)) {
            return Gate::check($model->stream()->slug . '.update', $model);
        }

        return true; // @todo remove
    }

    /**
     * Determine whether the user can delete the anomaly users module user user model.
     *
     * @param $user
     * @param $model
     * @return mixed
     */
    public function delete($user, $model)
    {
        return true; // @todo remove
    }

    /**
     * Determine whether the user can restore the anomaly users module user user model.
     *
     * @param $user
     * @param $model
     * @return mixed
     */
    public function restore($user, $model)
    {
        return true; // @todo remove
    }

    /**
     * Determine whether the user can permanently delete the anomaly users module user user model.
     *
     * @param $user
     * @param $model
     * @return mixed
     */
    public function forceDelete($user, $model)
    {
        return true; // @todo remove
    }
}
