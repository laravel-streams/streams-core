<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
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
     * @param Translator $translator
     */
    public function handle(Translator $translator)
    {
        $translator->addNamespace('streams', realpath(__DIR__ . '/../../../resources/lang'));
    }
}
