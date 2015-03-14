<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Command\RegisterAddons;
use Anomaly\Streams\Platform\Addon\Distribution\Command\DetectActiveDistribution;
use Anomaly\Streams\Platform\Addon\Module\Command\DetectActiveModule;
use Anomaly\Streams\Platform\Addon\Theme\Command\DetectActiveTheme;
use Illuminate\Foundation\Bus\DispatchesCommands;

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

    use DispatchesCommands;

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->dispatch(new RegisterAddons());
    }

    /**
     * Register the provider.
     */
    public function register()
    {
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
