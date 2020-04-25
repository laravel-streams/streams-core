<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Message\Facades\Messages;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Contract\ActionHandlerInterface;
use Illuminate\Support\Facades\Gate;

/**
 * Class ActionExecutor
 *
 * @link          http://anomaly.is/streams-plattable
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new ActionExecutor instance.
     *
     * @param Request          $request
     * @param Application      $application
     * @param ModuleCollection $modules
     */
    public function __construct(
        Request $request,
        Application $application,
        ModuleCollection $modules
    ) {
        $this->request     = $request;
        $this->modules     = $modules;
        $this->application = $application;
    }

    /**
     * Execute an action.
     *
     * @param  TableBuilder    $builder
     * @param  ActionInterface $action
     * @throws \Exception
     */
    public function execute(TableBuilder $builder, ActionInterface $action)
    {
        $options = $builder->getTableOptions();
        $handler = $action->getHandler();

        // Self handling implies @handle
        if (is_string($handler) && !str_contains($handler, '@')) {
            $handler .= '@handle';
        }

        /*
         * Authorize the action.
         */
        if ($action->policy && !Gate::any((array) $action->policy)) {

            Messages::error('streams::message.403');

            return;
        }

        /*
         * If no rows are selected then 
         * we have nothing to do. Heads up!
         */
        if (!$selected = $this->request->get($options->get('prefix') . 'id', [])) {

            messages('warning', trans('streams::message.no_rows_selected'));

            return;
        }

        /*
         * If the handler is a callable string or Closure
         * then call it using the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            if (is_string($handler) && class_exists($handler)) {
                $handler .= '@handle';
            }

            app()->call($handler, compact('builder', 'selected'));

            return;
        }

        /*
         * If the handle is an instance of ActionHandlerInterface
         * simply call the handle method on it.
         */
        if ($handler instanceof ActionHandlerInterface) {
            $handler->handle($builder, $selected);

            return;
        }

        throw new \Exception('Action $handler must be a callable string, Closure or ActionHandlerInterface.');
    }
}
