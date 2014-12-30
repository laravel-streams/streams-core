<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Action;

use Illuminate\Support\ServiceProvider;

/**
 * Class ActionServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Action
 */
class ActionServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('events')->listen(
            'streams::table.post',
            'Anomaly\Streams\Platform\Ui\Table\Component\Action\Listener\TablePostListener'
        );
    }
}
