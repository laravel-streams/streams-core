<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\ServiceProvider;

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

    protected function registerListeners()
    {
        $this->app['events']->listen(
            'Anomaly.Streams.Platform.Ui.Form.Event.*',
            'Anomaly\Streams\Platform\Ui\Form\FormListener'
        );
    }
}
