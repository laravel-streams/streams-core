<?php namespace Anomaly\Streams\Platform\User\Contract;

/**
 * Interface UserInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface UserInterface
{

    /**
     * Get the ID.
     *
     * @return int
     */
    public function getId();

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Return if the user has
     * a given permission.
     *
     * @param $permission
     * @return bool
     */
    public function hasPermission($permission);

    /**
     * Return if the user has any
     * of the given permissions.
     *
     * @param array $permissions
     * @return bool
     */
    public function hasAnyPermission(array $permissions);
}
