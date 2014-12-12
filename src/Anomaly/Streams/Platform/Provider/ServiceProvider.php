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
        $this->bindEntries();
        $this->bindStreams();
        $this->bindAssignments();

        $this->bindButtons();
        $this->bindIcons();
    }

    /**
     * Bind Streams.
     */
    protected function bindStreams()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Stream\StreamModel',
            config('streams::config.streams.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface',
            config('streams::config.streams.repository')
        );
    }

    /**
     * Bind Fields.
     */
    protected function bindFields()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Field\FieldModel',
            config('streams::config.fields.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface',
            config('streams::config.fields.repository')
        );
    }

    /**
     * Bind Assignments.
     */
    protected function bindAssignments()
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

    /**
     * Bind Entries.
     */
    protected function bindEntries()
    {
        $this->app->bind(
            'Anomaly\Streams\Platform\Entry\EntryModel',
            config('streams::config.entries.model')
        );

        $this->app->bind(
            '\Anomaly\Streams\Platform\Entry\Contract\EntryRepositoryInterface',
            config('streams::config.entries.repository')
        );
    }

    /**
     * Bind the dispatcher.
     */
    protected function bindDispatcher()
    {
        $this->app->singleton('streams.dispatcher', 'Anomaly\Streams\Platform\Support\Dispatcher');
    }

    /**
     * Bind the buttons.
     */
    protected function bindButtons()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Button\Contract\ButtonRepositoryInterface',
            config('streams::config.buttons.repository')
        );
    }

    /**
     * Bind the icons.
     */
    protected function bindIcons()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Ui\Icon\Contract\IconRepositoryInterface',
            config('streams::config.icons.repository')
        );
    }
}
