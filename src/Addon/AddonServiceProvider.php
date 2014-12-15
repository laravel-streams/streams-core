<?php namespace Anomaly\Streams\Platform\Addon;

/**
 * Class AddonServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the provider.
     */
    public function register()
    {
        $this->app->instance('streams.addon.paths', new AddonPaths());
        $this->app->instance('streams.addon.binder', new AddonBinder());
        $this->app->instance('streams.addon.loader', new AddonLoader());
        $this->app->instance('streams.addon.vendor', new AddonVendor());
        $this->app->instance('streams.addon.manager', new AddonManager());
        $this->app->instance('streams.addon.provider', new AddonProvider());
        $this->app->instance('streams.addon.integrator', new AddonIntegrator());

        $this->registerListeners();

        $this->app->register('Anomaly\Streams\Platform\Addon\Distribution\DistributionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Extension\ExtensionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\FieldType\FieldTypeServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Block\BlockServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Module\ModuleServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Theme\ThemeServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Tag\TagServiceProvider');

        $this->app->make('events')->fire('streams::addons.registered');
    }

    /**
     * Register the addon listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'streams::application.booting',
            'Anomaly\Streams\Platform\Addon\Listener\ApplicationBootingListener'
        );

        $this->app->make('events')->listen(
            'streams::addon.registered',
            'Anomaly\Streams\Platform\Addon\Listener\AddonRegisteredListener'
        );
    }
}
