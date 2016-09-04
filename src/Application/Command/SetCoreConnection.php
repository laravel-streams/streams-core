<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Config\Repository;

/**
 * Class SetCoreConnection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class SetCoreConnection
{

    /**
     * Handle the command.
     *
     * @param Repository $config
     */
    public function handle(Repository $config)
    {
        $config->set(
            'database.connections.core',
            $config->get('database.connections.' . $config->get('database.default'))
        );
    }
}
