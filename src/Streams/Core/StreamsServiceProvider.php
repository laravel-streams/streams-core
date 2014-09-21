<?php namespace Streams\Core;

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
        $this->loader->alias('Tag', 'Streams\Core\Facade\TagFacade');
        $this->loader->alias('Theme', 'Streams\Core\Facade\ThemeFacade');
        $this->loader->alias('Block', 'Streams\Core\Facade\BlockFacade');
        $this->loader->alias('Asset', 'Streams\Core\Facade\AssetFacade');
        $this->loader->alias('Image', 'Streams\Core\Facade\ImageFacade');
        $this->loader->alias('Module', 'Streams\Core\Facade\ModuleFacade');
        $this->loader->alias('Messages', 'Streams\Core\Facade\MessagesFacade');
        $this->loader->alias('Extension', 'Streams\Core\Facade\ExtensionFacade');
        $this->loader->alias('FieldType', 'Streams\Core\Facade\FieldTypeFacade');
        $this->loader->alias('Decorator', 'Streams\Core\Facade\DecoratorFacade');
        $this->loader->alias('Application', 'Streams\Core\Facade\ApplicationFacade');
        $this->loader->alias('StreamSchemaUtility', 'Streams\Core\Facade\StreamSchemaUtilityFacade');
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
        //\App::register('Streams\Core\Provider\AppServiceProvider');
        //\App::register('Streams\Core\Provider\ArtisanServiceProvider');
        //\App::register('App\Providers\FilterServiceProvider');
        \App::register('Streams\Core\Provider\LogServiceProvider');
        \App::register('Streams\Core\Provider\RouteServiceProvider');
        \App::register('Streams\Core\Provider\AssetServiceProvider');
        \App::register('Streams\Core\Provider\ImageServiceProvider');
        \App::register('Streams\Core\Provider\ErrorServiceProvider');
        \App::register('Streams\Core\Provider\MessagesServiceProvider');
        \App::register('Streams\Core\Provider\DecoratorServiceProvider');
        \App::register('Streams\Core\Provider\ApplicationServiceProvider');
        \App::register('Streams\Core\Provider\TranslationServiceProvider');

        \App::register('Streams\Core\Provider\AddonServiceProvider');
        \App::register('Streams\Core\Provider\FilterServiceProvider');
    }
}
