<?php namespace Streams\Platform\Provider;

use Streams\Platform\Support\Translator;

class TranslationServiceProvider extends \Illuminate\Translation\TranslationServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerLoader();
        $this->registerTranslator();
        $this->addStreamsNamespaceHint();
    }

    /**
     * Register the translator class for Streams.
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
     * Add the path hint for the Streams namespace.
     */
    protected function addStreamsNamespaceHint()
    {
        $this->app->bind(
            'path.lang',
            function ($app) {
                return __DIR__ . '/../../../../resources/lang';
            }
        );
    }
}
