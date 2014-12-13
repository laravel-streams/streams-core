<?php namespace Anomaly\Streams\Platform\Addon\Block;

use Anomaly\Streams\Platform\Addon\Block\Event\BlocksHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

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

    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Block\BlockListener'
        );
    }

    protected function registerCollection()
    {
        $this->app->instance('streams.blocks', new BlockCollection());
    }

    protected function registerBlocks()
    {
        $this->app->make('streams.addon.manager')->register('block');
    }
}
