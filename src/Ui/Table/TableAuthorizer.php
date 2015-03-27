<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Authorizer;

/**
 * Class TableAuthorizer
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableAuthorizer
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
     * Create a new TableAuthorizer instance.
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
     * @param TableBuilder $builder
     */
    public function authorize(TableBuilder $builder)
    {
        // Try the option first.
        $permission = $builder->getTableOption('permission');

        /**
         * If the option is not set then
         * try and automate the permission.
         */
        if (!$permission && ($module = $this->modules->active()) && ($stream = $builder->getTableStream())) {
            $permission = $module->getNamespace($stream->getSlug() . '.read');
        }

        $this->authorizer->authorize($permission);
    }
}
