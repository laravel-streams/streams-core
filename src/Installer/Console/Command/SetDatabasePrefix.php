<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class SetDatabasePrefix
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class SetDatabasePrefix
{
    use DispatchesJobs;

    /**
     * Handle the command.
     */
    public function handle()
    {
        app('db')->getSchemaBuilder()->getConnection()->setTablePrefix(env('APPLICATION_REFERENCE') . '_');
        app('db')->getSchemaBuilder()->getConnection()->getSchemaGrammar()->setTablePrefix(
            env('APPLICATION_REFERENCE') . '_'
        );
    }
}
