<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class SetDatabasePrefix
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
