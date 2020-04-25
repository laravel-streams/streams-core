<?php

namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Support\Facades\Gate;

/**
 * Class TableAuthorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableAuthorizer
{

    /**
     * Authorize the table.
     *
     * @param TableBuilder $builder
     */
    public function authorize(TableBuilder $builder)
    {
        /**
         * Configured policy options
         * take precedense over the 
         * model policy.
         */
        $policy = $builder->getTableOption('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         */
        $model = $builder->getTableModel();

        if ($model && !Gate::allows('viewAny', $model)) {
            abort(403);
        }
    }
}
