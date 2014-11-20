<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HandleTableActionCommandHandler
 *
 * Runs the executed table action handler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableActionCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleTableActionCommand $command
     * @return null
     */
    public function handle(HandleTableActionCommand $command)
    {
        $table = $command->getTable();

        $key = $table->getPrefix() . 'action';

        /**
         * If there is a submitted action to execute
         * then go ahead and handle it.
         */
        if ($executing = app('request')->get($key)) {

            $presets  = $table->getPresets();
            $expander = $table->getExpander();

            /**
             * Look through actions and find a match.
             */
            foreach ($table->getActions() as $slug => $action) {

                // Expand and automate.
                $action = $expander->expand($slug, $action);
                $action = $presets->setActionPresets($action);

                // Found the executing action? Nice, run it.
                if ($executing == $table->getPrefix() . $action['slug']) {

                    $this->setHandler($action, $table);
                    $this->runHandler($action, $table);

                    app('streams.messages')->flash();
                }
            }

            // Make sure we go back to where we came from.
            $table->setResponse(redirect(referer(url(app('request')->path()))));
        }
    }

    /**
     * Get the handler.
     *
     * @param array $action
     * @param Table $table
     * @return mixed
     */
    protected function setHandler(array &$action, Table $table)
    {
        if (is_string($action['handler'])) {

            $action['handler'] = app()->make($action['handler'], compact('table'));
        }
    }

    /**
     * Run the handler.
     *
     * @param array $action
     * @param Table $table
     */
    protected function runHandler(array $action, Table $table)
    {
        $ids = (array)app('request')->get($table->getPrefix() . 'id');

        /**
         * If the handler is a closure call it
         * through the container.
         */
        if ($action['handler'] instanceof \Closure) {

            app()->call($action['handler'], compact('table'));
        }

        /**
         * If the handler is an instance of the interface
         * then authorize and run it's handle method.
         */
        if ($action['handler'] instanceof TableActionInterface) {

            if ($action['handler']->authorize($table) !== false) {

                $action['handler']->handle($table, $ids);
            }
        }
    }
}
 