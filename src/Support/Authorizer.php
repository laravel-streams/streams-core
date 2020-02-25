<?php namespace Anomaly\Streams\Platform\Support;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class Authorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Authorizer
{

    /**
     * The guest role.
     *
     * @var RoleInterface
     */
    protected $guest;

    /**
     * Authorize a user against a permission.
     *
     * @param $permission
     * @param null $user
     * @return bool
     */
    public function authorize($permission, $user = null)
    {
        if (!$user) {
            $user = user();
        }

        if (!$user) {
            $user = request()->user();
        }

        if (!$user && $guest = $this->getGuest()) {
            return $guest->hasPermission($permission);
        }

        if (!$user) {
            return false;
        }

        return $this->checkPermission($permission, $user);
    }

    /**
     * Authorize a user against any permission.
     *
     * @param  array $permissions
     * @param  $user
     * @param  bool $strict
     * @return bool
     */
    public function authorizeAny(array $permissions, $user = null, $strict = false)
    {
        if (!$user) {
            $user = user();
        }

        if (!$user) {
            return !$strict;
        }

        foreach ($permissions as $permission) {
            if ($this->checkPermission($permission, $user)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Authorize a user against all permission.
     *
     * @param  array $permissions
     * @param  $user
     * @param  bool $strict
     * @return bool
     */
    public function authorizeAll(array $permissions, $user = null, $strict = false)
    {
        if (!$user) {
            $user = user();
        }

        if (!$user) {
            return !$strict;
        }

        foreach ($permissions as $permission) {
            if (!$this->checkPermission($permission, $user)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return a user's permission.
     *
     * @param                $permission
     * @param  $user
     * @return bool
     */
    protected function checkPermission($permission, $user)
    {
        /*
         * No permission, let it proceed.
         */
        if (!$permission) {
            return true;
        }

        /*
         * If the permission does not actually exist
         * then we cant really do anything with it.
         */
        if (str_is('*::*.*', $permission) && !ends_with($permission, '*')) {
            $parts = explode('.', str_replace('::', '.', $permission));
            $end   = array_pop($parts);
            $group = array_pop($parts);
            $parts = explode('::', $permission);

            // If it does not exist, we are authorized.
            if (!in_array($end, (array)config($parts[0] . '::permissions.' . $group))) {
                return true;
            }
        } elseif (ends_with($permission, '*')) {
            $parts = explode('::', $permission);

            $addon = array_shift($parts);

            /*
             * Check vendor.module.slug::group.*
             * then check vendor.module.slug::*
             */
            if (str_is('*.*.*::*.*.*', $permission)) {
                $end = trim(substr($permission, strpos($permission, '::') + 2), '.*');

                if (!$permissions = config($addon . '::permissions.' . $end)) {
                    return true;
                } else {
                    return $user->hasAnyPermission($permissions);
                }
            } elseif (str_is('*.*.*::*.*', $permission)) {
                $end = trim(substr($permission, strpos($permission, '::') + 2), '.*');

                if (!$permissions = config($addon . '::permissions.' . $end)) {
                    return true;
                } else {
                    $check = [];

                    foreach ($permissions as &$permission) {
                        $check[] = $addon . '::' . $end . '.' . $permission;
                    }

                    return $user->hasAnyPermission($check);
                }
            } else {
                if (!$permissions = config($addon . '::permissions')) {
                    return true;
                } else {
                    $check = [];

                    foreach ($permissions as $group => &$permission) {
                        foreach ($permission as $access) {
                            $check[] = $addon . '::' . $group . '.' . $access;
                        }
                    }

                    return $user->hasAnyPermission($check);
                }
            }
        } else {
            $parts = explode('::', $permission);

            $end = array_pop($parts);

            if (!in_array($end, (array)config($parts[0] . '::permissions'))) {
                return true;
            }
        }

        // Check if the user actually has permission.
        if (!$user || !$user->hasPermission($permission)) {
            return false;
        }

        return true;
    }

    /**
     * Authorize a user against a role.
     *
     * @param RoleInterface $role
     * @param  $user
     * @return bool
     */
    public function authorizeRole(RoleInterface $role, $user = null)
    {
        if (!$user) {
            $user = user();
        }

        if (!$user) {
            $user = request()->user();
        }

        if ($this->isGuest($role)) {
            return $user ? false : true;
        }

        if (!$user) {
            return false;
        }

        return $user->hasRole($role);
    }

    /**
     * Authorize a user against any role.
     *
     * @param Collection $roles
     * @param  $user
     * @return bool
     */
    public function authorizeAnyRole(Collection $roles, $user = null)
    {
        if ($roles->isEmpty()) {
            return true;
        }

        if (!$user) {
            $user = user();
        }

        if (!$user) {
            $user = request()->user();
        }

        if (!$user) {
            return false;
        }

        return $user->hasAnyRole($roles);
    }

    /**
     * Get the guest role.
     *
     * @return RoleInterface
     */
    public function getGuest()
    {
        return $this->guest;
    }

    /**
     * Set the guest role.
     *
     * @param  RoleInterface $guest
     * @return $this
     */
    public function setGuest(RoleInterface $guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Return whether a role is
     * the guest role or not.
     *
     * @param RoleInterface $role
     * @return bool
     */
    public function isGuest(RoleInterface $role)
    {
        $guest = $this->getGuest();

        return $guest->getSlug() === $role->getSlug();
    }
}
