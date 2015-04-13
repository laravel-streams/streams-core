<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;

/**
 * Class SetActiveView
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
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $table   = $this->builder->getTable();
        $options = $table->getOptions();
        $views   = $table->getViews();

        if ($view = $views->findBySlug($request->get($options->get('prefix') . 'view'))) {
            $view->setActive(true);
        }

        if (!$view && $view = $views->first()) {
            $view->setActive(true);
        }
    }
}
