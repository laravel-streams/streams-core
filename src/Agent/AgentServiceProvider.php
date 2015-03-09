<?php namespace Anomaly\Streams\Platform\Agent;

use Illuminate\Support\ServiceProvider;

/**
 * Class AgentServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Agent
 */
class AgentServiceProvider extends ServiceProvider
{

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->app->make('twig')->addExtension($this->app->make('Anomaly\Streams\Platform\Agent\AgentPlugin'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
