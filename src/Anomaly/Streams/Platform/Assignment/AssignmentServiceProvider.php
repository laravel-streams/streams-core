<?php namespace Anomaly\Streams\Platform\Assignment;

use Illuminate\Support\ServiceProvider;

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

    protected function registerBindings()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            config('streams::config.assignments.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface',
            config('streams::config.assignments.repository')
        );
    }

    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Assignment.Event.*',
            'Anomaly\Streams\Platform\Assignment\AssignmentListener'
        );
    }
}
