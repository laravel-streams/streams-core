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
}
