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
        $policy = $builder->table->options->get('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         */
        if (!$builder->stream) {
            return;
        }

        $model = $builder->stream->model;

        if ($model && !Gate::allows('viewAny', $model)) {
            abort(403);
        }
    }
}
