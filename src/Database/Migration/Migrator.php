<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Command\Migrate;
use Anomaly\Streams\Platform\Database\Migration\Command\Rollback;
use Anomaly\Streams\Platform\Database\Migration\Command\TransformMigrationNameToClass;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Migrator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration
 */
class Migrator extends \Illuminate\Database\Migrations\Migrator
{

    use DispatchesJobs;

    /**
     * The migration namespace.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * The migration repository.
     *
     * @var MigrationRepository
     */
    protected $repository;

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
     * Run "up" a migration instance.
     *
     * @param  string $file
     * @param  int    $batch
     * @param  bool   $pretend
     *
     * @return void
     */
    protected function runUp($file, $batch, $pretend)
    {
        $instance = $this->resolve($file);

        if ($instance instanceof Migration) {
            $this->dispatch(new Migrate($instance));
        }

        parent::runUp($file, $batch, $pretend);
    }

    /**
     * Run "down" a migration instance.
     *
     * @param  object $migration
     * @param  bool   $pretend
     *
     * @return void
     */
    protected function runDown($migration, $pretend)
    {
        $instance = $this->resolve($migration->migration);

        if ($instance instanceof Migration) {
            $this->dispatch(new Rollback($instance));
        }

        parent::runDown($migration, $pretend);
    }

    /**
     * Require a given migration file.
     *
     * @param $file
     */
    protected function requireOnce($file)
    {
        $namespace = $this->getNamespaceFromMigrationFile($file);

        $addons = app('Anomaly\Streams\Platform\Addon\AddonCollection');

        /* @var Addon $addon */
        if ($addon = $addons->get($namespace)) {
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
     * @return Migration
     */
    public function resolve($file)
    {
        $this->requireOnce($file);

        if (!str_is('*.*.*', $file)) {
            return parent::resolve($file);
        }

        return app($this->dispatch(new TransformMigrationNameToClass($this->removeDatePrefix($file))));
    }

    /**
     * Remove the date prefix from
     * a given migration file.
     *
     * @param $file
     * @return string
     */
    public function removeDatePrefix($file)
    {
        return implode('_', array_slice(explode('_', $file), 4));
    }

    /**
     * Get the namespace from a
     * given migration file.
     *
     * @param $file
     * @return string
     */
    public function getNamespaceFromMigrationFile($file)
    {
        $segments = explode('__', $this->removeDatePrefix($file));

        return $segments[0];
    }

    /**
     * Rollback the last migration operation.
     *
     * @param       $namespace
     * @param  bool $pretend
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
            $this->runDown((object)$migration, $pretend);
        }

        return count($migrations);
    }

    /**
     * Rollback the last migration operation.
     *
     * @param       $namespace
     * @param  bool $pretend
     * @return int
     */
    public function rollbackPackage($path, $pretend = false)
    {
        $this->notes = [];

        // We want to pull in the last batch of migrations that ran on the previous
        // migration operation. We'll then reverse those migrations and run each
        // of them "down" to reverse the last migration "operation" which ran.
        $migrations = $this->repository->findManyByFiles($files = $this->getMigrationFiles($path));

        $this->requireFiles($path, $files);

        if (count($migrations) == 0) {

            $this->note("<info>Nothing to rollback: {$path}</info>");

            return count($migrations);
        }

        // We need to reverse these migrations so that they are "downed" in reverse
        // to what they run on "up". It lets us backtrack through the migrations
        // and properly reverse the entire database schema operation that ran.
        foreach ($migrations as $migration) {
            $this->runDown((object)$migration, $pretend);
        }

        return count($migrations);
    }
}
