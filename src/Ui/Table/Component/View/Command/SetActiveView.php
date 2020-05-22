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
        if ($this->builder->table->views->active()) {
            return;
        }

        if ($view = $this->builder->table->views->findBySlug($request->get($this->builder->table->options->get('prefix') . 'view'))) {
            $view->active = true;
        }

        if (!$view && $view = $this->builder->table->views->first()) {
            $view->active = true;
        }

        // Nothing to do.
        if (!$view) {
            return;
        }

        if ($view->filters) {
            $this->builder->filters = $view->filters;
        }

        if ($view->columns) {
            $this->builder->columns = $view->columns;
        }

        if ($view->buttons) {
            $this->builder->buttons = $view->buttons;
        }

        if ($view->actions) {
            $this->builder->actions = $view->actions;
        }

        if ($view->options) {
            $this->builder->options = $view->options;
        }

        if ($view->entries) {
            $this->builder->entries = $view->entries;
        }

        $handler->handle($this->builder, $view);
    }
}
