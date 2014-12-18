<?php namespace Anomaly\Streams\Platform\Ui\Table\View\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class RunTableQueryHookCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View\Command
 */
class RunTableQueryHookCommandHandler
{

    /**
     * Apply table views.
     *
     * @param RunTableQueryHookCommand $command
     */
    public function handle(RunTableQueryHookCommand $command)
    {
        $query   = $command->getQuery();
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $views   = $table->getViews();

        if (!$view = $views->active()) {
            return;
        }

        $this->runTableQueryHook($view, $builder, $query);
    }

    /**
     * Apply the view.
     *
     * @param ViewInterface $view
     * @param TableBuilder  $builder
     * @param Builder       $query
     */
    protected function runTableQueryHook(ViewInterface $view, TableBuilder $builder, Builder $query)
    {
        $view->onTableQuerying($builder, $query);
    }
}
