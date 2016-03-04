<?php namespace Anomaly\Streams\Platform\Support;

use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Auth\Guard;
use Illuminate\Config\Repository;

/**
 * Class Authorizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Authorizer
{

    /**
     * The user repository.
     *
     * @var RoleRepositoryInterface $roles
     */
    protected $roles;

    /**
     * The auth utility.
     *
     * @var Guard
     */
    protected $guard;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new Authorizer instance.
     *
     * @param RoleRepositoryInterface $roles
     * @param Guard                   $guard
     * @param Repository              $config
     */
    function __construct(RoleRepositoryInterface $roles, Guard $guard, Repository $config)
    {
        $this->guard  = $guard;
        $this->roles  = $roles;
        $this->config = $config;
    }

    /**
     * Authorize a user against a permission.
     *
     * @param               $permission
     * @param UserInterface $user
     * @return bool
     */
    public function authorize($permission, UserInterface $user = null)
    {
        if (!$user) {
            $user = $this->guard->user();
        }

        if (!$user && $guest = $this->roles->findBySlug('guest')) {
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
     * @param array         $permissions
     * @param UserInterface $user
     * @return bool
     */
    public function authorizeAny(array $permissions, UserInterface $user = null)
    {
        if (!$user) {
            $user = $this->guard->user();
        }

        if (!$user) {
            return true; // Don't know about this.
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
     * @param array         $permissions
     * @param UserInterface $user
     * @return bool
     */
    public function authorizeAll(array $permissions, UserInterface $user = null)
    {
        if (!$user) {
            $user = $this->guard->user();
        }

        if (!$user) {
            return true; // Don't know about this.
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
     * @param               $permission
     * @param UserInterface $user
     * @return bool
     */
    protected function checkPermission($permission, UserInterface $user)
    {
        /**
         * No permission, let it proceed.
         */
        if (!$permission) {
            return true;
        }

        /**
         * If the permission does not actually exist
         * then we cant really do anything with it.
         */
        if (str_is('*::*.*', $permission) && !ends_with($permission, '*')) {

            $parts = explode('.', str_replace('::', '.', $permission));
            $end   = array_pop($parts);
            $group = array_pop($parts);
            $parts = explode('::', $permission);

            // If it does not exist, we are authorized.
            if (!in_array($end, (array)$this->config->get($parts[0] . '::permissions.' . $group))) {
                return true;
            }
        } elseif (ends_with($permission, '*')) {

            $parts = explode('::', $permission);

            $addon = array_shift($parts);

            /**
             * Check vendor.module.slug::group.*
             * then check vendor.module.slug::*
             */
            if (str_is('*.*.*::*.*.*', $permission)) {

                $end = trim(substr($permission, strpos($permission, '::') + 2), '.*');

                if (!$permissions = $this->config->get($addon . '::permissions.' . $end)) {
                    return true;
                } else {
                    return $user->hasAnyPermission($permissions);
                }
            } elseif (str_is('*.*.*::*.*', $permission)) {

                $end = trim(substr($permission, strpos($permission, '::') + 2), '.*');

                if (!$permissions = $this->config->get($addon . '::permissions.' . $end)) {
                    return true;
                } else {

                    $check = [];

                    foreach ($permissions as &$permission) {
                        $check[] = $addon . '::' . $end . '.' . $permission;
                    }

                    return $user->hasAnyPermission($check);
                }
            } else {
                if (!$permissions = $this->config->get($addon . '::permissions')) {
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

            if (!in_array($end, (array)$this->config->get($parts[0] . '::permissions'))) {
                return true;
            }
        }

        // Check if the user actually has permission.
        if (!$user || !$user->hasPermission($permission)) {
            return false;
        }

        return true;
    }
}
