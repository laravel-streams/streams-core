<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Facades\Gate;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;

/**
 * Class FormAuthorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FormAuthorizer
{

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

        if (!config('streams.installed')) {
            return;
        }

        // @todo revisit
        // if ($permission && !$this->authorizer->authorizeAny((array) $permission)) {
        //     abort(403);
        // }

        // And the second option second.
        $model = $builder->getFormModel();

        if ($model && !Gate::allows($builder->getFormMode(), $model)) {
            abort(403);
        }
    }
}
