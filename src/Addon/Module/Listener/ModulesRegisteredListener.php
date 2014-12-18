<?php namespace Anomaly\Streams\Platform\Addon\Module\Listener;

use Laracasts\Commander\CommanderTrait;

/**
 * Class ModulesRegisteredListener
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module\Listener
 */
class ModulesRegisteredListener
{

    use CommanderTrait;

    /**
     * When all the modules have been registered
     * bind the installed / enabled states from
     * the database to the addons.
     */
    public function handle()
    {
        if (app('streams.application')->isInstalled()) {
            $this->execute('Anomaly\Streams\Platform\Addon\Module\Command\SetModuleStatesCommand');
        }
    }
}
