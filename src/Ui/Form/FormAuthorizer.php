<?php

namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\Facades\Gate;
use Anomaly\Streams\Platform\Support\Authorizer;
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
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new FormAuthorizer instance.
     *
     * @param ModuleCollection $modules
     * @param Authorizer       $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

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

        if ($permission && !$this->authorizer->authorizeAny((array) $permission)) {
            abort(403);
        }

        // And the second option second.
        $model = $builder->getFormModel();

        if ($model && !Gate::allows($builder->getFormMode(), $model)) {
            abort(403);
        }
    }
}
