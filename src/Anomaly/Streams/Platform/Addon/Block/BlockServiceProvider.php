<?php namespace Anomaly\Streams\Platform\Addon\Block;

use Anomaly\Streams\Platform\Addon\Block\Event\BlocksHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

/**
 * Class BlockServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Block
 */
class BlockServiceProvider extends ServiceProvider
{

    use EventGenerator;
    use DispatchableTrait;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerListeners();
        $this->registerCollection();

        $this->registerBlocks();

        $this->raise(new BlocksHaveRegistered());

        $this->dispatchEventsFor($this);
    }

    /**
     * Register the block listener.
     */
    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            'Anomaly\Streams\Platform\Addon\Block\BlockListener'
        );
    }

    /**
     * Register the block collection.
     */
    protected function registerCollection()
    {
        $this->app->instance('streams.blocks', new BlockCollection());
    }

    /**
     * Register all block addons.
     */
    protected function registerBlocks()
    {
        $this->app->make('streams.addon.manager')->register('block');
    }
}
