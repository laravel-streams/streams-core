<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\Rollback;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Cache\Store;

/**
 * Class RollbackHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackHandler
{

    /**
     * The cache store.
     *
     * @var Store
     */
    protected $cache;

    /**
     * Create a new RollbackHandler instance.
     *
     * @param CacheManager $cache
     */
    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache->store();
    }

    /**
     * Handle the command.
     *
     * @param Rollback $command
     */
    public function handle(Rollback $command)
    {
        $migration = $command->getMigration();

        $migration->unassignFields();
        $migration->deleteStream();
        $migration->deleteFields();

        $this->cache->flush();
    }
}
