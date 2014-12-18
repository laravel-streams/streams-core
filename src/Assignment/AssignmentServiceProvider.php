<?php namespace Anomaly\Streams\Platform\Assignment;

use Illuminate\Support\ServiceProvider;

/**
 * Class AssignmentServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
 */
class AssignmentServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->registerListeners();
    }

    /**
     * Register assignment management bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            config('streams::config.assignments.model')
        );

        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface',
            config('streams::config.assignments.repository')
        );
    }

    /**
     * Register the assignment listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::assignment.created',
            'Anomaly\Streams\Platform\Assignment\Listener\AssignmentCreatedListener'
        );

        $this->app->make('events')->listen(
            'streams::assignment.saved',
            'Anomaly\Streams\Platform\Assignment\Listener\AssignmentSavedListener'
        );

        $this->app->make('events')->listen(
            'streams::assignment.deleted',
            'Anomaly\Streams\Platform\Assignment\Listener\AssignmentDeletedListener'
        );
    }
}
