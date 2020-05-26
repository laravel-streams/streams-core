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
     * Authorize the table.
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
        $policy = $builder->tree->options->get('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         * 
         * @todo Use stream here instead?
         */
        $model = $builder->tree->model;

        if ($model && !Gate::allows('viewAny', $model)) {
            abort(403);
        }
    }
}
