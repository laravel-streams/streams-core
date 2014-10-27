<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Illuminate\Http\Request;

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

        $handler = app(get_class($ui) . '@action-' . $this->request->get('_action'));

        if ($handler instanceof \Closure) {

            try {

                $response = $handler($ui);

            } catch (\Exception $e) {

                app('streams.messages')->add('error', $e->getMessage());

            }

        } else {

            try {

                $response = (new $handler($ui))->handle();

            } catch (\Exception $e) {

                app('streams.messages')->add('error', $e->getMessage());

            }

        }

        return $response;
    }

}
 