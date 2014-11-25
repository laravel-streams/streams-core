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
            if ($view['slug'] == $appliedView or array_search($slug, array_keys($views)) == 0) {

                $view['handler'] = $this->getHandler($view, $table);

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
    protected function getHandler(array $view, Table $table)
    {
        if (is_string($view['handler'])) {

            $utility = $table->getUtility();

            return $utility->autoComplete($view['handler'], $table);
        }

        return $view;
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
        /**
         * If the handler is a string then
         * run it through the container.
         */
        if (is_string($view['handler'])) {

            app()->call($view['handler'], compact('table'));
        }

        /**
         * If the handler is a Closure then
         * run it through the container.
         */
        if ($view['handler'] instanceof \Closure) {

            app()->call($view['handler'], compact('table'));
        }

        /**
         * If the handler is an instance of the
         * TableViewInterface then run it's handle
         * method as defined.
         */
        if ($view['handler'] instanceof TableViewInterface) {

            $view['handler']->handle($table);
        }
    }
}
 