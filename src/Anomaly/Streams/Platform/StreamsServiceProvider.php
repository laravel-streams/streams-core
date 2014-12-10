<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Support\YamlConfigFileLoader;
use Illuminate\Support\ServiceProvider;
use Laracasts\Commander\Events\DispatchableTrait;
use Laracasts\Commander\Events\EventGenerator;
use Symfony\Component\Yaml\Parser;

/**
 * Class StreamsServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsServiceProvider extends ServiceProvider
{

    /**
     * Everything has booted.
     */
    public function boot()
    {
        $this->app->make('events')->fire('booted');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPackageAliases();
        $this->registerPackages();
        $this->registerCore();
    }

    /**
     * Register package aliases.
     */
    protected function registerPackageAliases()
    {
        // We'll leave core aliases in tact though they are not used in core.
        // People will expect these to be available based on past experience.

        // Be warned these will likely be making their exit in future
        // releases of the Laravel framework. They are a somewhat
        // poor practice in pattern so let's just ignore them..
        $this->app->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        $this->app->alias('Agent', 'Jenssegers\Agent\Facades\Agent');

        $this->app->alias('Form', 'Illuminate\Html\FormFacade');
        $this->app->alias('HTML', 'Illuminate\Html\HtmlFacade');
    }

    /**
     * Register package service providers.
     */
    protected function registerPackages()
    {
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Anomaly\Lexicon\LexiconServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Laracasts\Commander\CommanderServiceProvider');
        $this->app->register('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider');

        $this->app->register('Illuminate\Html\HtmlServiceProvider');
    }

    /**
     * Register core service providers.
     */
    protected function registerCore()
    {
        $this->app->register('Anomaly\Streams\Platform\Provider\ServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ExceptionServiceProvider');

        $this->app->register('Anomaly\Streams\Platform\Provider\ApplicationServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\TransformerServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\MessagesServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ListenerServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\LoaderServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\AssetServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ImageServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ModelServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\CacheServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ViewServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\LogServiceProvider');

        // Deferred
        $this->app->register('Anomaly\Streams\Platform\Provider\TranslationServiceProvider');

        // Register addon components.
        $this->app->register('Anomaly\Streams\Platform\Provider\AddonServiceProvider');

        // Setup some application components.
        $this->app->register('Anomaly\Streams\Platform\Provider\ActiveDistributionServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ActiveModuleServiceProvider');
        $this->app->register('Anomaly\Streams\Platform\Provider\ActiveThemeServiceProvider');
    }
}
