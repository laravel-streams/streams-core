<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Authorizer;

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
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new FormAuthorizer instance.
     *
     * @param ModuleCollection $modules
     * @param Authorizer       $authorizer
     */
    public function __construct(ModuleCollection $modules, Authorizer $authorizer)
    {
        $this->modules    = $modules;
        $this->authorizer = $authorizer;
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

            $permission = $module->getNamespace($stream->getSlug() . '.' . ($entry->getId() ? 'edit' : 'create'));
        }

        $this->authorizer->authorize($permission);
    }
}
