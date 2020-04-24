<?php

namespace Anomaly\Streams\Platform\Security;

use Illuminate\Support\Traits\Macroable;

/**
 * Class Policy
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Policy
{

    use Macroable;

    /**
     * Determine whether the user can view any anomaly users module user user models.
     *
     * @param $user
     * @return mixed
     */
    public function viewAny($user)
    {
        if ($this->hasMacro('view_any')) {
            return $this->call('view_any', [
                'user' => $user,
            ]);
        }
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
        if ($this->hasMacro('view')) {
            return $this->call('view', [
                'user' => $user,
                'model' => $model,
            ]);
        }
    }

    /**
     * Determine if the user
     * can create an entry.
     *
     * @param $user
     * @return mixed
     */
    public function create($user)
    {
        if ($this->hasMacro('create')) {
            return $this->call('create', [
                'user' => $user,
            ]);
        }
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
        if ($this->hasMacro('update')) {
            return $this->call('update', [
                'user' => $user,
                'model' => $model,
            ]);
        }
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
        if ($this->hasMacro('delete')) {
            return $this->call('delete', [
                'user' => $user,
                'model' => $model,
            ]);
        }
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
        if ($this->hasMacro('restore')) {
            return $this->call('restore', [
                'user' => $user,
                'model' => $model,
            ]);
        }
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
        if ($this->hasMacro('force_delete')) {
            return $this->call('force_delete', [
                'user' => $user,
                'model' => $model,
            ]);
        }
    }
}
