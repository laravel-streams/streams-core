<?php namespace Anomaly\Streams\Platform\Support;

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
     * @param Guard      $guard
     * @param Repository $config
     */
    function __construct(Guard $guard, Repository $config)
    {
        $this->guard  = $guard;
        $this->config = $config;
    }

    /**
     * Authorize the active user against a permission.
     *
     * @param               $permission
     * @param bool          $return
     * @param UserInterface $user
     * @return bool
     */
    public function authorize($permission, $return = false, UserInterface $user = null)
    {
        if ($user === null) {
            $user = $this->guard->user();
        }

        /**
         * No permission, let it proceed.
         */
        if (!$permission) {
            return true;
        }

        /**
         * If we have a erroneous permission
         * then we still can't do much.
         */
        if (str_is('*::*.*', $permission)) {

            $parts = explode('.', str_replace('::', '.', $permission));
            $end   = array_pop($parts);
            $group = array_pop($parts);
            $parts = explode('::', $permission);

            if (!in_array($end, (array)$this->config->get($parts[0] . '::permissions.' . $group))) {
                return true;
            }
        } else {

            $parts = explode('::', $permission);

            $end = array_pop($parts);

            if (!in_array($end, (array)$this->config->get($parts[0] . '::permissions'))) {
                return true;
            }
        }

        /**
         * Finally test things out.
         */
        if ($user && !$user->hasPermission($permission)) {
            if ($return) {
                return false;
            }

            abort(403);
        }

        return true;
    }
}
