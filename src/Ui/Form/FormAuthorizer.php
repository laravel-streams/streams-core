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

        /**
         * Configured policy options
         * take precedense over the 
         * model policy.
         */
        $policy = $builder->form->options->get('policy');

        if ($policy && !Gate::any((array) $policy)) {
            abort(403);
        }

        /**
         * Default behavior is to
         * rely on the model policy.
         * 
         * @todo Use stream here instead
         */
        $model = null;//$builder->form->model;

        if ($model && !Gate::allows($builder->mode, $model)) {
            abort(403);
        }
    }
}
