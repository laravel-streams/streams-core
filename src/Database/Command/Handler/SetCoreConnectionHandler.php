<?php namespace Anomaly\Streams\Platform\Database\Command\Handler;

use Illuminate\Contracts\Config\Repository;

/**
 * Class SetCoreConnectionHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Command\Handler
 */
class SetCoreConnectionHandler
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new SetCoreConnectionHandler instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->config->set(
            'database.connections.core',
            $this->config->get('database.connections.' . $this->config->get('database.default'))
        );
    }
}
