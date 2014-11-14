<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Support\YamlFileLoader;
use Anomaly\Streams\Platform\Support\Translator;
use Symfony\Component\Yaml\Parser;

class TranslationServiceProvider extends \Illuminate\Translation\TranslationServiceProvider
{

    /**
     * Setup translation services.
     */
    public function register()
    {
        $this->registerLoader();
        $this->registerTranslator();
        $this->addStreamsLangPath();
    }

    /**
     * Register the loader for language files.
     */
    protected function registerLoader()
    {
        $parser = new Parser();

        $this->app->bindShared(
            'translation.loader',
            function ($app) use ($parser) {
                return new YamlFileLoader($app['files'], $parser, streams_path('resources/lang'));
            }
        );
    }

    /**
     * Use our own translator class.
     */
    protected function registerTranslator()
    {
        $this->app->bindShared(
            'translator',
            function ($app) {
                $loader = $app['translation.loader'];

                // When registering the translator component, we'll need to set the default
                // locale as well as the fallback locale. So, we'll grab the application
                // configuration so we can easily get both of these values from there.
                $locale = $app['config']['app.locale'];

                $translator = new Translator($loader, $locale);

                $translator->setFallback($app['config']['app.fallback_locale']);

                return $translator;
            }
        );
    }

    /**
     * Add the "streams" lang path.
     */
    protected function addStreamsLangPath()
    {
        $this->app->bind(
            'path.lang',
            function () {
                return __DIR__ . '/../../../../../resources/lang';
            }
        );
    }
}
