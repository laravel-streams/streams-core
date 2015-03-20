<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Anomaly\UsersModule\User\Contract\User;
use Illuminate\Auth\Guard;
use Illuminate\Foundation\Application;
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
     * The authentication guard.
     *
     * @var Guard
     */
    protected $guard;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * The application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new ActionExecutor instance.
     *
     * @param Guard       $guard
     * @param Request     $request
     * @param MessageBag  $messages
     * @param Application $application
     */
    public function __construct(Guard $guard, Request $request, Application $application, MessageBag $messages)
    {
        $this->guard       = $guard;
        $this->request     = $request;
        $this->messages    = $messages;
        $this->application = $application;
    }

    /**
     * Execute an action.
     *
     * @param Table           $table
     * @param ActionInterface $action
     * @return mixed
     */
    public function execute(Table $table, ActionInterface $action)
    {
        $options = $table->getOptions();
        $handler = $action->getHandler();

        $user = $this->guard->getUser();

        /**
         * Make sure the permission is met if present.
         */
        if ($user instanceof User && !$user->hasPermission($action->getPermission())) {

            abort(403);

            return false;
        }

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
