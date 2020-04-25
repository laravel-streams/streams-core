<?php

namespace Anomaly\Streams\Platform\Ui\Grid;

use Illuminate\Support\Facades\Gate;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

/**
 * Class GridAuthorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GridAuthorizer
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new GridAuthorizer instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules    = $modules;
    }

    /**
     * Authorize the grid.
     *
     * @param GridBuilder $builder
     */
    public function authorize(GridBuilder $builder)
    {
        /**
         * Configured policy options
         * take precedense over the 
         * model policy.
         */
        $policy = $builder->getGridOption('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         */
        $model = $builder->getGridModel();

        if ($model && !Gate::allows('viewAny', $model)) {
            abort(403);
        }
    }
}
