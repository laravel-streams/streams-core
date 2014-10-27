<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;
use Anomaly\Streams\Platform\Ui\Table\Contract\TableActionInterface;

/**
 * Class HandleActionRequestCommandHandler
 * Runs the table action handler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class HandleActionRequestCommandHandler
{

    /**
     * The request class.
     *
     * @var
     */
    protected $request;

    /**
     * Create a new HandleActionRequestCommandHandler instance.
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
     * @param HandleActionRequestCommand $command
     * @return null
     */
    public function handle(HandleActionRequestCommand $command)
    {
        $response = null;

        $ui = $command->getUi();

        // Resolve the handler out of the IoC that we registered earlier.
        $handler = app(get_class($ui) . '@action-' . $this->request->get('_action'));

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

        } else {

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

                if ($handler->authorize()) {

                    $response = $handler->handle();

                }

            } catch (\Exception $e) {

                app('streams.messages')->add('error', $e->getMessage());

            }

        }

        return $response;
    }

}
 