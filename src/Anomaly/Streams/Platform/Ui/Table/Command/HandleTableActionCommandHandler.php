<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Http\Request;

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
     * The HTTP request class.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Create a new HandleTableActionCommandHandler instance.
     *
     * @param Request $request
     */
    function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the command.
     *
     * @param HandleTableActionCommand $command
     * @return null
     */
    public function handle(HandleTableActionCommand $command)
    {
        $response = null;

        $table = $command->getTable();

        $flag = $table->getPrefix() . 'action';

        /**
         * If there is a submitted action to execute
         * then go ahead and handle it.
         */
        if ($executing = $this->request->get($flag)) {

            $this->handleAction($executing, $table);

            app('streams.messages')->flash();

            return redirect(referer(url(app('request')->path())));
        }

        return null;
    }

    /**
     * Get the handler.
     *
     * @param array   $action
     * @param Table $table
     * @return mixed
     */
    protected function getHandler(array $action, Table $table)
    {
        if (is_string($action['handler'])) {

            return app()->make($action['handler'], compact('ui', 'action'));
        }

        return $action['handler'];
    }

    /**
     * Handle the action.
     *
     * @param         $executing
     * @param Table $table
     */
    protected function handleAction($executing, Table $table)
    {
        foreach ($table->getActions() as $action) {

            if ($executing == $table->getPrefix() . $action['slug']) {

                $handler = $this->getHandler($action, $table);

                $this->runHandler($handler, $table);
            }
        }
    }

    /**
     * Run the handler.
     *
     * @param         $handler
     * @param Table $table
     */
    protected function runHandler($handler, Table $table)
    {
        if ($handler instanceof \Closure) {

            $handler();
        }

        if ($handler instanceof TableActionInterface) {

            if ($handler->authorize() !== false) {

                $handler->handle((array)app('request')->get($table->getPrefix() . 'id'));
            }
        }
    }
}
 