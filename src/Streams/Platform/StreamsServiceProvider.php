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
        $this->registerCoreAliases();

        $this->registerPackages();
        $this->registerCore();
    }

    /**
     * Register package aliases.
     */
    protected function registerPackageAliases()
    {
        $this->loader->alias('Debugbar', 'Barryvdh\Debugbar\Facade');
        $this->loader->alias('Agent', 'Jenssegers\Agent\Facades\Agent');
        $this->loader->alias('Sentry', 'Cartalyst\Sentry\Facades\Laravel\Sentry');

        $this->loader->alias('Form', 'Illuminate\Html\FormFacade');
        $this->loader->alias('HTML', 'Illuminate\Html\HtmlFacade');
    }

    /**
     * Register core aliases.
     */
    protected function registerCoreAliases()
    {
        $this->loader->alias('Tag', 'Streams\Platform\Facade\TagFacade');
        $this->loader->alias('Theme', 'Streams\Platform\Facade\ThemeFacade');
        $this->loader->alias('Block', 'Streams\Platform\Facade\BlockFacade');
        $this->loader->alias('Asset', 'Streams\Platform\Facade\AssetFacade');
        $this->loader->alias('Image', 'Streams\Platform\Facade\ImageFacade');
        $this->loader->alias('Module', 'Streams\Platform\Facade\ModuleFacade');
        $this->loader->alias('Messages', 'Streams\Platform\Facade\MessagesFacade');
        $this->loader->alias('Extension', 'Streams\Platform\Facade\ExtensionFacade');
        $this->loader->alias('FieldType', 'Streams\Platform\Facade\FieldTypeFacade');
        $this->loader->alias('Decorator', 'Streams\Platform\Facade\DecoratorFacade');
        $this->loader->alias('Application', 'Streams\Platform\Facade\ApplicationFacade');
        $this->loader->alias('StreamSchemaUtility', 'Streams\Platform\Facade\StreamSchemaUtilityFacade');
    }

    /**
     * Register package service providers.
     */
    protected function registerPackages()
    {
        \App::register('Barryvdh\Debugbar\ServiceProvider');
        \App::register('Jenssegers\Agent\AgentServiceProvider');
        \App::register('Anomaly\Lexicon\LexiconServiceProvider');
        \App::register('Cartalyst\Sentry\SentryServiceProvider');
        \App::register('Intervention\Image\ImageServiceProvider');

        \App::register('Illuminate\Html\HtmlServiceProvider');
    }

    /**
     * Register core service providers.
     */
    protected function registerCore()
    {
        //\App::register('Streams\Platform\Provider\AppServiceProvider');
        //\App::register('Streams\Platform\Provider\ArtisanServiceProvider');
        //\App::register('App\Providers\FilterServiceProvider');
        \App::register('Streams\Platform\Provider\LogServiceProvider');
        \App::register('Streams\Platform\Provider\RouteServiceProvider');
        \App::register('Streams\Platform\Provider\AssetServiceProvider');
        \App::register('Streams\Platform\Provider\ImageServiceProvider');
        \App::register('Streams\Platform\Provider\ErrorServiceProvider');
        \App::register('Streams\Platform\Provider\MessagesServiceProvider');
        \App::register('Streams\Platform\Provider\DecoratorServiceProvider');
        \App::register('Streams\Platform\Provider\ApplicationServiceProvider');
        \App::register('Streams\Platform\Provider\TranslationServiceProvider');

        \App::register('Streams\Platform\Provider\AddonServiceProvider');
        \App::register('Streams\Platform\Provider\FilterServiceProvider');
    }
}
