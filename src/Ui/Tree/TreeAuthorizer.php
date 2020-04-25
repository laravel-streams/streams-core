<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Illuminate\Support\Facades\Gate;
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
        /**
         * Configured policy options
         * take precedense over the 
         * model policy.
         */
        $policy = $builder->getTreeOption('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         */
        $model = $builder->getTreeModel();

        if ($model && !Gate::allows('viewAny', $model)) {
            abort(403);
        }
    }
}
