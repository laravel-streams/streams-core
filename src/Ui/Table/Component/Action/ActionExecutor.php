<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Http\Request;

/**
 * Class ActionExecutor
 *
 * @link          http://anomaly.is/streams-plattable
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionExecutor
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new ActionExecutor instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Execute an action.
     *
     * @param Table $table
     * @param       $handler
     * @throws \Exception
     * @return
     */
    public function execute(Table $table, $handler)
    {
        $options = $table->getOptions();

        /**
         * Get the IDs of the selected rows.
         */
        $selected = $this->request->get($options->get('prefix') . 'id');

        /**
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            return app()->call($handler, compact('table', 'selected'));
        }

        /**
         * If the handle is an instance of ActionHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionHandlerInterface) {
            return $handler->handle($table, $selected);
        }

        throw new \Exception('Action $handler must be a callable string, Closure or ActionHandlerInterface.');
    }
}
