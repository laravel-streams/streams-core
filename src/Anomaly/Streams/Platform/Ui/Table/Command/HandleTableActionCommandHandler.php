<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Table\TableUi;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;

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
     * @var
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

            return redirect(referer(url(app('request')->path())));

        }

        return null;
    }

    /**
     * Get the handler.
     *
     * @param array                                      $action
     * @param \Anomaly\Streams\Platform\Ui\Table\TableUi $ui
     * @return mixed
     */
    protected function getHandler(array $action, TableUi $ui)
    {
        if (is_string($action['handler'])) {

            return app()->make($action['handler'], compact('ui'));

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

                $this->runHandler($handler);

            }

        }
    }

    /**
     * Run the handler.
     *
     * @param $handler
     */
    protected function runHandler($handler)
    {
        if ($handler instanceof \Closure) {

            $handler();

        }

        if ($handler instanceof TableActionInterface) {

            if ($handler->authorize()) {

                $handler->handle();

            }

        }
    }

}
 