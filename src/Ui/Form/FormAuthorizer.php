<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Illuminate\Auth\Guard;
use Illuminate\Config\Repository;

/**
 * Class FormAuthorizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormAuthorizer
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
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new FormAuthorizer instance.
     *
     * @param Guard            $guard
     * @param Repository       $config
     * @param ModuleCollection $modules
     */
    public function __construct(Guard $guard, Repository $config, ModuleCollection $modules)
    {
        $this->guard   = $guard;
        $this->config  = $config;
        $this->modules = $modules;
    }

    /**
     * Authorize the table.
     *
     * @param FormBuilder $builder
     */
    public function authorize(FormBuilder $builder)
    {
        // Try the option first.
        $permission = $builder->getFormOption('permission');

        /**
         * If the option is not set then
         * try and automate the permission.
         */
        if (!$permission && ($module = $this->modules->active()) && ($stream = $builder->getFormStream())) {

            $entry = $builder->getFormEntry();

            $permission = $module->getNamespace(
                'permissions.' . $stream->getSlug() . '.' . ($entry->getId() ? 'edit' : 'create')
            );
        }

        /**
         * No permission, let it proceed.
         */
        if (!$permission) {
            return;
        }

        /**
         * If we have a erroneous permission
         * then we still can't do much.
         */

        $parts = explode('.', $permission);

        $end = array_pop($parts);

        if (!in_array($end, $this->config->get(implode('.', $parts)))) {
            return;
        }

        /* @var UserInterface $user */
        $user = $this->guard->user();

        /**
         * Finally test things out.
         */
        if ($user && !$user->hasPermission($permission)) {
            abort(403);
        }
    }
}
