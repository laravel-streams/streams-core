<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Command\TransformMigrationNameToClass;
use Illuminate\Database\Migrations\Migrator as BaseMigrator;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class Migrator
 *
 * @package Anomaly\Streams\Platform\Database\Migration
 */
class Migrator extends BaseMigrator
{
    use DispatchesCommands;

    /**
     * @var string|null
     */
    protected $namespace;

    /**
     * @param $namespace
     *
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Run an array of migrations.
     *
     * @param  array $migrations
     * @param  bool  $pretend
     *
     * @return void
     */
    public function runMigrationList($migrations, $pretend = false)
    {
        // First we will just make sure that there are any migrations to run. If there
        // aren't, we will just make a note of it to the developer so they're aware
        // that all of the migrations have been run against this database system.
        if (count($migrations) == 0) {

            $this->note("<info>Nothing to migrate: {$this->namespace}</info>");

            return;
        }

        $batch = $this->repository->getNextBatchNumber();

        // Once we have the array of migrations, we will spin through them and run the
        // migrations "up" so the changes are made to the databases. We'll then log
        // that the migration was run so we don't repeat it next time we execute.
        foreach ($migrations as $file) {
            $this->runUp($file, $batch, $pretend);
        }
    }

    /**
     * @param $file
     */
    protected function requireOnce($file)
    {
        $namespace = $this->getNamespaceFromMigrationFile($file);

        $addonCollection = (new AddonCollection())->merged();

        if ($addon = $addonCollection->get($namespace)) {

            $path = $addon->getPath('migrations/') . $file . '.php';

        } else {

            $path = base_path('database/migrations/') . $file . '.php';
        }

        if (is_file($path)) {

            $this->files->requireOnce($path);
        }
    }

    /**
     * Resolve a migration instance from a file.
     *
     * @param  string $file
     *
     * @return object
     */
    public function resolve($file)
    {
        $this->requireOnce($file);

        return app($this->dispatch(new TransformMigrationNameToClass($this->removeDatePrefix($file))));
    }

    /**
     * @param $file
     *
     * @return string
     */
    public function removeDatePrefix($file)
    {
        return implode('_', array_slice(explode('_', $file), 4));
    }

    /**
     * @param $file
     *
     * @return string
     */
    public function getNamespaceFromMigrationFile($file)
    {
        $file = $this->removeDatePrefix($file);

        $segments = explode('__', $file);

        return $segments[0];
    }

    /**
     * Rollback the last migration operation.
     *
     * @param       $namespace
     * @param  bool $pretend
     *
     * @return int
     */
    public function rollbackNamespace($namespace, $pretend = false)
    {
        $this->notes = [];

        // We want to pull in the last batch of migrations that ran on the previous
        // migration operation. We'll then reverse those migrations and run each
        // of them "down" to reverse the last migration "operation" which ran.
        $migrations = $this->repository->findManyByNamespace($namespace);

        if (count($migrations) == 0) {
            $this->note("<info>Nothing to rollback: {$namespace}</info>");

            return count($migrations);
        }

        // We need to reverse these migrations so that they are "downed" in reverse
        // to what they run on "up". It lets us backtrack through the migrations
        // and properly reverse the entire database schema operation that ran.
        foreach ($migrations as $migration) {
            $this->runDown((object) $migration, $pretend);
        }

        return count($migrations);
    }

}