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
        $this->registerStreamsPath();
        $this->registerTranslator();
    }

    /**
     * Register the streams path for language.
     */
    protected function registerStreamsPath()
    {
        $this->app->bind(
            'path.lang',
            function ($app) {
                return __DIR__ . '/../../../../resources/lang';
            }
        );
    }

    /**
     * Register the translator component.
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

                $trans = new Translator($loader, $locale);

                $trans->setFallback($app['config']['app.fallback_locale']);

                return $trans;
            }
        );
    }
}
