<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Addon\Theme\ThemeCollection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Http\Request;

/**
 * Class SetDefaultOptions
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class SetDefaultOptions
{

    /**
     * Handle the command.
     *
     * @param ModuleCollection $modules
     * @param FormBuilder $builder
     */
    public function handle(ModuleCollection $modules, FormBuilder $builder)
    {
        /*
         * Default the form view based on the request.
         */
        if (!$builder->getFormOption('form_view')) {
            $builder->setFormOption('form_view', 'admin::form/form');
        }

        /*
         * Default the form wrapper view as well.
         */
        if (!$builder->getFormOption('wrapper_view') && $builder->isAjax()) {
            $builder->setFormOption('wrapper_view', 'admin::ajax');
        }

        if (!$builder->getFormOption('wrapper_view')) {
            $builder->setFormOption('wrapper_view', 'admin::default');
        }

        /*
         * If the permission is not set then
         * try and automate it.
         */
        if (
            $builder->getFormOption('permission') === null &&
            request()->segment(1) == 'admin' &&
            ($module = $modules->active()) && ($stream = $builder->getFormStream())
        ) {
            $builder->setFormOption(
                'permission',
                $module->getNamespace($stream->getSlug() . '.write')
            );
        }

        $builder->setFormOption('ajax', $builder->isAjax());
    }
}
