<?php namespace Streams\Platform;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class StreamsServiceProvider extends ServiceProvider
{
    /**
     * Create a new StreamsServiceProvider instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->loader = AliasLoader::getInstance();
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
        // poor practice in pattern.
        $this->loader->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        $this->loader->alias('Agent', 'Jenssegers\Agent\Facades\Agent');
        $this->loader->alias('Sentry', 'Cartalyst\Sentry\Facades\Laravel\Sentry');

        $this->loader->alias('Form', 'Illuminate\Html\FormFacade');
        $this->loader->alias('HTML', 'Illuminate\Html\HtmlFacade');
    }

    /**
     * Register package service providers.
     */
    protected function registerPackages()
    {
        $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        $this->app->register('Jenssegers\Agent\AgentServiceProvider');
        $this->app->register('Anomaly\Lexicon\LexiconServiceProvider');
        $this->app->register('Cartalyst\Sentry\SentryServiceProvider');
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('Laracasts\Commander\CommanderServiceProvider');

        $this->app->register('Illuminate\Html\HtmlServiceProvider');
    }

    /**
     * Register core service providers.
     */
    protected function registerCore()
    {
        $this->app->register('Streams\Platform\Provider\ApplicationServiceProvider');
        $this->app->register('Streams\Platform\Provider\DecoratorServiceProvider');
        $this->app->register('Streams\Platform\Provider\PresenterServiceProvider');
        $this->app->register('Streams\Platform\Provider\MessagesServiceProvider');
        $this->app->register('Streams\Platform\Provider\HelpersServiceProvider');
        $this->app->register('Streams\Platform\Provider\FilterServiceProvider');
        $this->app->register('Streams\Platform\Provider\LoaderServiceProvider');
        $this->app->register('Streams\Platform\Provider\AssetServiceProvider');
        $this->app->register('Streams\Platform\Provider\ImageServiceProvider');
        $this->app->register('Streams\Platform\Provider\ErrorServiceProvider');
        $this->app->register('Streams\Platform\Provider\RouteServiceProvider');
        $this->app->register('Streams\Platform\Provider\ModelServiceProvider');
        $this->app->register('Streams\Platform\Provider\EventServiceProvider');
        $this->app->register('Streams\Platform\Provider\ViewServiceProvider');
        $this->app->register('Streams\Platform\Provider\AuthServiceProvider');
        $this->app->register('Streams\Platform\Provider\LogServiceProvider');

        // Deferred
        $this->app->register('Streams\Platform\Provider\TranslationServiceProvider');
        $this->app->register('Streams\Platform\Provider\AddonServiceProvider');

        // Setup some application components.
        $this->app->register('Streams\Platform\Provider\ModuleServiceProvider');
        $this->app->register('Streams\Platform\Provider\ThemeServiceProvider');
    }
}
