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
        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            'Anomaly\Streams\Platform\Assignment\AssignmentModel'
        );

        $this->app->singleton(
            'Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface',
            'Anomaly\Streams\Platform\Assignment\AssignmentRepository'
        );

        $this->app->register('Anomaly\Streams\Platform\Assignment\AssignmentEventProvider');
    }
}
