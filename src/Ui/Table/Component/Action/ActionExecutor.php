<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;
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
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * The application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new ActionExecutor instance.
     *
     * @param Guard            $guard
     * @param Request          $request
     * @param MessageBag       $messages
     * @param Authorizer       $authorizer
     * @param Application      $application
     * @param ModuleCollection $modules
     */
    public function __construct(
        Guard $guard,
        Request $request,
        MessageBag $messages,
        Authorizer $authorizer,
        Application $application,
        ModuleCollection $modules
    ) {
        $this->request     = $request;
        $this->modules     = $modules;
        $this->messages    = $messages;
        $this->authorizer  = $authorizer;
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

        /**
         * If the option is not set then
         * try and automate the permission.
         */
        if (!$action->getPermission() && ($module = $this->modules->active()) && ($stream = $table->getStream())
        ) {
            $action->setPermission($module->getNamespace($stream->getSlug() . '.' . $action->getSlug()));
        }

        /**
         * Authorize the action.
         */
        if (!$this->authorizer->authorize($action->getPermission(), true)) {

            $this->messages->error('streams::message.403');

            return;
        }

        /**
         * Get the IDs of the selected rows.
         */
        $selected = $this->request->get($options->get('prefix') . 'id', []);

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
