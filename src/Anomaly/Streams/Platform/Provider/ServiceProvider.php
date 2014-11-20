<?php namespace Anomaly\Streams\Platform\Provider;

/**
 * Class ServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Provider
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindDispatcher();

        $this->bindFields();
        $this->bindStreams();
        $this->bindAssignments();
    }

    /**
     * Bind Streams.
     */
    protected function bindStreams()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            config('streams.streams.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            config('streams.streams.repository')
        );
    }

    /**
     * Bind Fields.
     */
    protected function bindFields()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Field\FieldModel',
            config('streams.fields.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface',
            config('streams.fields.repository')
        );
    }

    /**
     * Bind Assignments.
     */
    protected function bindAssignments()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Assignment\AssignmentModel',
            config('streams.assignments.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface',
            config('streams.assignments.repository')
        );
    }

    /**
     * Bind the dispatcher.
     */
    protected function bindDispatcher()
    {
        $this->app->singleton('streams.dispatcher', 'Anomaly\Streams\Platform\Support\Dispatcher');
    }
}
 