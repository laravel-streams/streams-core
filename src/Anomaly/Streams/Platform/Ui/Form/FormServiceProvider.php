<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\ServiceProvider;

/**
 * Class FormServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
    }

    /**
     * Register the form listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Ui.Form.Event.*',
            'Anomaly\Streams\Platform\Ui\Form\FormListener'
        );
    }
}
