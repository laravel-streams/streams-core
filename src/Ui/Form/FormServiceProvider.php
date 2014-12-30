<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Support\ServiceProvider;

/**
 * Class FormServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form
 */
class FormServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        app('twig')->addExtension(app('Anomaly\Streams\Platform\Ui\Form\FormPlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerComponents();
        $this->registerSubscribers();
    }

    /**
     * Register components.
     */
    protected function registerComponents()
    {
        //$this->app->register('Anomaly\Streams\Platform\Ui\Form\Component\Field\FieldServiceProvider');
    }

    /**
     * Register event subscribers.
     */
    protected function registerSubscribers()
    {
        $this->app->make('events')->subscribe(
            'Anomaly\Streams\Platform\Ui\Form\Subscriber\FormBuildSubscriber'
        );
    }
}
