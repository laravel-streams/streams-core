<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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

        if ($permission === false) {
            return;
        }

        // Use this to help out.
        $module = $this->modules->active();

        // Auto prefix if no module prefix is set.
        if ($permission && strpos($permission, '::') === false && $module) {
            $permission = $module->getNamespace($permission);
        }

        /**
         * If the option is not set then
         * try and automate the permission.
         */
        if (!$permission && $module && ($stream = $builder->getFormStream())) {

            $entry = $builder->getFormEntry();

            if ($entry instanceof EntryInterface) {
                $permission = $module->getNamespace($stream->getSlug() . '.write');
            }
        }

        if (!$this->authorizer->authorize($permission)) {
            abort(403);
        }
    }
}
