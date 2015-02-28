<?php namespace Anomaly\Streams\Platform\Application\Command;

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
     */
    public function handle(Configurator $configurator)
    {
        $configurator->addNamespace('streams', realpath(__DIR__ . '/../../../resources/config'));
    }
}
