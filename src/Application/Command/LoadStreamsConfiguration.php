<?php namespace Anomaly\Streams\Platform\Application\Command;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Support\Configurator;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class LoadStreamsConfiguration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class LoadStreamsConfiguration implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Configurator $configurator
     * @param Application  $application
     */
    public function handle(Configurator $configurator, Application $application)
    {
        // Load package configuration.
        $configurator->addNamespace('streams', realpath(__DIR__ . '/../../../resources/config'));

        // Load system overrides.
        $configurator->addNamespaceOverrides('streams', base_path('resources/core/config/streams'));

        // Load application overrides.
        $configurator->addNamespaceOverrides('streams', $application->getResourcesPath('config/streams'));
    }
}
