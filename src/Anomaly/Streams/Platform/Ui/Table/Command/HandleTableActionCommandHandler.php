<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;

/**
 * Class HandleTableActionCommandHandler
 * Runs the table action handler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleTableActionCommandHandler
{

    /**
     * The request class.
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

        /**
         * Look through actions and find a matching slug.
         */
        foreach ($ui->getActions() as $action) {

            if ($action['slug'] == $this->request->get('_action')) {

                $handler = $action['handler'];

                /**
                 * If the handler is a closure just run
                 * it and pass the table UI object along.
                 */
                if ($handler instanceof \Closure) {

                    try {

                        $response = $handler($ui);

                    } catch (\Exception $e) {

                        app('streams.messages')->add('error', $e->getMessage());

                    }

                } elseif (is_string($handler) and $handler = app($handler)) {

                    /**
                     * If it's not a closure it MUST be an instance
                     * of the TableActionInterface. Tell em about it.
                     */
                    if (!$handler instanceof TableActionInterface) {

                        $class = get_class($handler);

                        throw new \Exception("[{$class}] should implement Anomaly\\Streams\\Platform\\Ui\\Table\\Contract\\TableActionInterface");

                    }

                    /**
                     * The table action should either authorize and do it's thing
                     * and set some success messages or throw an \Exception
                     * telling us what went wrong. This message will get
                     * flashed later to the UI when redirecting.
                     */
                    try {

                        if ($handler->authorize() !== false) {

                            $response = $handler->handle();

                        }

                    } catch (\Exception $e) {

                        app('streams.messages')->add('error', $e->getMessage());

                    }

                }

            }

        }

        return $response;
    }

}
 