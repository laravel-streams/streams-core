<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\View\ViewHandler;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

/**
 * Class SetActiveView.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View\Command
 */
class SetActiveView implements SelfHandling
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
     * @param Request   $request
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

        if ($view = $views->findBySlug($request->get($options->get('prefix').'view'))) {
            $view->setActive(true);
        }

        if (! $view && $view = $views->first()) {
            $view->setActive(true);
        }

        // Nothing to do.
        if (! $view) {
            return;
        }

        // Set columns from active view.
        if (($columns = $view->getColumns()) !== null) {
            $this->builder->setColumns($columns);
        }

        // Set buttons from active view.
        if (($buttons = $view->getButtons()) !== null) {
            $this->builder->setButtons($buttons);
        }

        // Set actions from active view.
        if (($actions = $view->getActions()) !== null) {
            $this->builder->setActions($actions);
        }

        $handler->handle($this->builder, $view);
    }
}
