<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Foundation\Application;

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
