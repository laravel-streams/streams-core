<?php namespace Anomaly\Streams\Platform\Addon\Block;

use Illuminate\Support\ServiceProvider;

/**
 * Class BlockServiceProvider
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Block
 */
class BlockServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCollection();
        $this->registerBlocks();
    }

    /**
     * Register the block collection.
     */
    protected function registerCollection()
    {
        $this->app->singleton(
            'Anomaly\Streams\Platform\Addon\Block\BlockCollection',
            'Anomaly\Streams\Platform\Addon\Block\BlockCollection'
        );
    }

    /**
     * Register all block addons.
     */
    protected function registerBlocks()
    {
        $this->app->make('Anomaly\Streams\Platform\Addon\AddonManager')->register('block');
    }
}
