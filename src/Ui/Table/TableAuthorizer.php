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
        // Try the option first.
        $permission = $builder->getTableOption('permission');

        // @todo revisit
        // if ($permission && !$this->authorizer->authorize($permission)) {
        //     abort(403);
        // }

        // And the second option second.
        $model = $builder->getTableModel();

        if ($model && !Gate::any(['viewAny', 'view'], $model)) {
            abort(403);
        }
    }
}
