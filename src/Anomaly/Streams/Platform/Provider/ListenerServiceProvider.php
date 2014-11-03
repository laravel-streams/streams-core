<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class ListenerServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        app('events')->listen(
            'Anomaly.Streams.Platform.Addon.Module.Event.*',
            'Anomaly\Streams\Platform\Addon\Module\ModuleListener'
        );
        app('events')->listen(
            'Anomaly.Streams.Platform.Stream.Event.*',
            'Anomaly\Streams\Platform\Stream\StreamListener'
        );
        app('events')->listen(
            'Anomaly.Streams.Platform.Assignment.Event.*',
            'Anomaly\Streams\Platform\Assignment\AssignmentListener'
        );
        app('events')->listen(
            'Anomaly.Streams.Platform.Ui.Form.*',
            'Anomaly\Streams\Platform\Ui\Form\FormListener'
        );
    }
}
