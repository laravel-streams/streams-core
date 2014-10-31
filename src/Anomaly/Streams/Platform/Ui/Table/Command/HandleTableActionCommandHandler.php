<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;
use Anomaly\Streams\Platform\Ui\Table\TableUi;
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

        $ui = $command->getUi();

        $flag = $ui->getPrefix() . 'action';

        /**
         * If there is a submitted action to execute
         * then go ahead and handle it.
         */
        if ($executing = $this->request->has($flag)) {

            $this->handleAction($ui);

            app('streams.messages')->flash();

            return redirect(referer(url(app('request')->path())));
        }

        return null;
    }

    /**
     * Get the handler.
     *
     * @param array   $action
     * @param TableUi $ui
     * @return mixed
     */
    protected function getHandler(array $action, TableUi $ui)
    {
        if (is_string($action['handler'])) {

            return app()->make($action['handler'], compact('ui', 'action'));
        }

        return $action['handler'];
    }

    /**
     * Handle the action.
     *
     * @param TableUi $ui
     */
    protected function handleAction(TableUi $ui)
    {
        foreach ($ui->getActions() as $action) {

            if ($executing = $action['slug']) {

                $handler = $this->getHandler($action, $ui);

                $this->runHandler($handler, $ui);
            }
        }
    }

    /**
     * Run the handler.
     *
     * @param         $handler
     * @param TableUi $ui
     */
    protected function runHandler($handler, TableUi $ui)
    {
        if ($handler instanceof \Closure) {

            $handler();
        }

        if ($handler instanceof TableActionInterface) {

            if ($handler->authorize() !== false) {

                $handler->handle(app('request')->get((array)$ui->getPrefix() . 'id'));
            }
        }
    }
}
 