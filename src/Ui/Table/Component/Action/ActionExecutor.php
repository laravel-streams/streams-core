<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Application;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Message\Facades\Messages;
use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\Table\Component\Action\Action;

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
     * @param Application      $application
     * @param ModuleCollection $modules
     */
    public function __construct(
        Application $application,
        ModuleCollection $modules
    ) {
        $this->modules     = $modules;
        $this->application = $application;
    }

    /**
     * Execute an action.
     *
     * @param  TableBuilder $builder
     * @param  Action $action
     * @throws \Exception
     */
    public function execute(TableBuilder $builder, Action $action)
    {
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
        if (!$selected = $builder->request('id', [])) {

            messages('warning', trans('streams::message.no_rows_selected'));

            return;
        }

        App::call($action->handler, compact('builder', 'selected'), 'handle');

        return;
    }
}
