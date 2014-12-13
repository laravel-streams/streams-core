<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Distribution\Event\DistributionsHaveRegistered;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;

class DistributionServiceProvider extends ServiceProvider
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

        $this->registerDistributions();

        $this->raise(new DistributionsHaveRegistered());

        $this->dispatchEventsFor($this);
    }

    protected function registerListeners()
    {
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Application.Event.*',
            '\Anomaly\Streams\Platform\Addon\Distribution\DistributionListener'
        );
        $this->app->make('events')->listen(
            'Anomaly.Streams.Platform.Addon.*',
            '\Anomaly\Streams\Platform\Addon\Distribution\DistributionListener'
        );
    }

    protected function registerCollection()
    {
        $this->app->instance('streams.distributions', new DistributionCollection());
    }

    protected function registerDistributions()
    {
        $this->app->make('streams.addon.manager')->register('distribution');
    }
}
