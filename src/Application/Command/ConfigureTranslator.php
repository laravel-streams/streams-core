<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Lang\Loader;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Application;
use Illuminate\Translation\Translator;

/**
 * Class ConfigureTranslator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class ConfigureTranslator implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Repository  $config
     * @param Application $application
     */
    public function handle(Repository $config, Application $application)
    {

        /**
         * Change the lang loader so we can
         * add a few more necessary override
         * paths to the API.
         */
        $application->singleton(
            'translation.loader',
            function () use ($application) {
                return new Loader($application->make('files'), $application->make('path.lang'));
            }
        );

        /**
         * Re-bind the translator so we can use
         * the new loader defined above.
         */
        $application->singleton(
            'translator',
            function () use ($application) {
                $loader = $application->make('translation.loader');

                // When registering the translator component, we'll need to set the default
                // locale as well as the fallback locale. So, we'll grab the application
                // configuration so we can easily get both of these values from there.
                $locale = $application->make('config')->get('app.locale');

                $trans = new Translator($loader, $locale);

                $trans->setFallback($application->make('config')->get('app.fallback_locale'));

                return $trans;
            }
        );
        
        /**
         * Set the locale if LOCALE is defined.
         *
         * LOCALE is defined first thing in our
         * HTTP Kernel. Respect it!
         */
        if (defined('LOCALE')) {
            $application->setLocale(LOCALE);
            $config->set('app.locale', LOCALE);
        }

        // Set our locale namespace.
        $application->make('translator')->addNamespace('streams', realpath(__DIR__ . '/../../../resources/lang'));
    }
}
