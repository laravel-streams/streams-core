<?php namespace Anomaly\Streams\Platform\Addon;

/**
 * Class AddonServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon
 */
class AddonServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the provider.
     */
    public function register()
    {
        // Register utilities.
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\AddonPaths',
            'Anomaly\Streams\Platform\Addon\AddonPaths'
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\AddonBinder',
            'Anomaly\Streams\Platform\Addon\AddonBinder'
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\AddonLoader',
            'Anomaly\Streams\Platform\Addon\AddonLoader'
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\AddonProvider',
            'Anomaly\Streams\Platform\Addon\AddonProvider'
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\AddonIntegrator',
            'Anomaly\Streams\Platform\Addon\AddonIntegrator'
        );
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\AddonManager',
            'Anomaly\Streams\Platform\Addon\AddonManager'
        );

        // Register component service providers.
        $this->app->register('Anomaly\Streams\Platform\Addon\Distribution\DistributionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Module\ModuleServiceProvider');

        // Keep this order (modules before extensions) for now..
        $this->app->register('Anomaly\Streams\Platform\Addon\Extension\ExtensionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\FieldType\FieldTypeServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Plugin\PluginServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Block\BlockServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Addon\Theme\ThemeServiceProvider');
    }
}
