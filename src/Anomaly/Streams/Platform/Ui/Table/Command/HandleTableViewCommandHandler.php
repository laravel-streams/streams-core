<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableViewInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HandleTableViewCommandHandler
 *
 * Handle the query hook for table views.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableViewCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleTableViewCommand $command
     * @return mixed
     */
    public function handle(HandleTableViewCommand $command)
    {
        $table = $command->getTable();

        $views    = $table->getViews();
        $presets  = $table->getPresets();
        $expander = $table->getExpander();

        $appliedView = app('request')->get($table->getPrefix() . 'view');

        /**
         * Find the applied view and run it.
         * If nothing is set use the first view.
         */
        foreach ($views as $slug => $view) {

            // Expand and automate.
            $view = $expander->expand($slug, $view);
            $view = $presets->setViewPresets($view);

            // If the view is applied then handle it.
            if ($view['slug'] == $appliedView or (!$appliedView and array_search($slug, array_keys($views)))) {

                // Set the handler and run it.
                $this->setHandler($view, $table);
                $this->runHandler($view, $table);
            }
        }
    }

    /**
     * Set the handler.
     *
     * @param array $view
     * @param Table $table
     * @return mixed
     */
    protected function setHandler(array &$view, Table $table)
    {
        if (is_string($view['handler'])) {

            app()->make($view['handler'], compact('table'));
        }
    }

    /**
     * Run the handler.
     *
     * @param array $view
     * @param Table $table
     * @return mixed
     */
    protected function runHandler(array $view, Table $table)
    {
        if ($view['handler'] instanceof \Closure) {

            app()->call($view['handler'], compact('table'));
        }

        if ($view['handler'] instanceof TableViewInterface) {

            $view['handler']->handle($table);
        }
    }
}
 