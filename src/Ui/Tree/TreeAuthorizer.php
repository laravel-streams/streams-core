<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

/**
 * Class TreeAuthorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TreeAuthorizer
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
     * Create a new TreeAuthorizer instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules    = $modules;
    }

    /**
     * Authorize the tree.
     *
     * @param TreeBuilder $builder
     */
    public function authorize(TreeBuilder $builder)
    {
        // Try the option first.
        $permission = $builder->getTreeOption('permission');

        /*
         * If the option is not set then
         * try and automate the permission.
         */
        if (!$permission && ($module = $this->modules->active()) && ($stream = $builder->getTreeStream())) {
            $permission = $module->getNamespace($stream->getSlug() . '.read');
        }

        // @todo revisit
        // if (!$this->authorizer->authorize($permission)) {
        //     abort(403);
        // }
    }
}
