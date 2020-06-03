<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Workflows\Views;

use Illuminate\Http\Request;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewHandler;

/**
 * Class SetActiveView
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SetActiveView
{

    /**
     * Handle the command.
     *
     * @param Request $request
     * @param Container $container
     */
    public function handle(TableBuilder $builder, Request $request, ViewHandler $handler)
    {
        if ($builder->instance->views->active()) {
            return;
        }

        if ($view = $builder->instance->views->findBySlug($request->get($builder->instance->options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $builder->instance->views->first()) {
            $view->active = true;
        }

        // Nothing to do.
        if (!$view) {
            return;
        }

        if ($view->filters) {
            $builder->filters = $view->filters;
        }

        if ($view->columns) {
            $builder->columns = $view->columns;
        }

        if ($view->buttons) {
            $builder->buttons = $view->buttons;
        }

        if ($view->actions) {
            $builder->actions = $view->actions;
        }

        if ($view->options) {
            $builder->options = $view->options;
        }

        if ($view->entries) {
            $builder->entries = $view->entries;
        }

        $handler->handle($builder, $view);
    }
}
