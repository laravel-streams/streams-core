<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

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
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTableFiltersCommand instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Request $request
     * @param Container $container
     */
    public function handle(Request $request, ViewHandler $handler)
    {
        $table   = $this->builder->getTable();
        $options = $table->getOptions();
        $views   = $table->getViews();

        if ($views->active()) {
            return;
        }

        if ($view = $views->findBySlug($request->get($options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $views->first()) {
            $view->active = true;
        }

        // Nothing to do.
        if (!$view) {
            return;
        }

        if ($view->filters) {
            $this->builder->setFilters($view->filters);
        }

        if ($view->columns) {
            $this->builder->setColumns($view->columns);
        }

        if ($view->buttons) {
            $this->builder->setButtons($view->buttons);
        }

        if ($view->actions) {
            $this->builder->setActions($view->actions);
        }

        if ($view->options) {
            $this->builder->setOptions($view->options);
        }

        if ($view->entries) {
            $this->builder->setEntries($view->entries);
        }

        $handler->handle($this->builder, $view);
    }
}
