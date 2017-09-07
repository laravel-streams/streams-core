<?php namespace Anomaly\Streams\Platform\Cache\Console;

/**
 * Make the cache table artisan command
 */
class MakeTable extends \Illuminate\Cache\Console\CacheTableCommand
{

    /**
     * Create a base migration file for the table.
     *
     * @return string
     */
    protected function createBaseMigration()
    {
        $name = 'create_cache_table';

        $path = $this->laravel->databasePath().'/migrations';

        return $this->laravel['migration.creator']
            ->setInput($this->input)
            ->create($name, $path);
    }
}
