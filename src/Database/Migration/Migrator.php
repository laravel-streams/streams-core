<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Command\Migrate;
use Anomaly\Streams\Platform\Database\Migration\Command\Reset;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class Migrator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Migrator extends \Illuminate\Database\Migrations\Migrator
{

    use DispatchesJobs;

    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon = null;

    /**
     * The migration repository.
     *
     * @var MigrationRepository
     */
    protected $repository;

    /**
     * Rolls all of the currently applied migrations back.
     *
     * @param  array|string $paths
     * @param  bool         $pretend
     * @return array
     */
    public function reset($paths = [], $pretend = false)
    {
        $this->repository->setAddon($this->getAddon());

        return parent::reset($paths, $pretend);
    }

    /**
     * Rollback the last migration operation.
     *
     * @param  array|string $paths
     * @param  array        $options
     * @return array
     */
    public function rollback($paths = [], array $options = [])
    {
        $this->repository->setAddon($this->getAddon());

        return parent::rollback($paths, $options);
    }

    /**
     * Run "up" a migration instance.
     *
     * @param  string $file
     * @param  int    $batch
     * @param  bool   $pretend
     * @return void
     */
    protected function runUp($file, $batch, $pretend)
    {

        /**
         * Run our migrations first.
         *
         * @var Migration $migration
         */
        $migration = $this->resolve($file);

        /**
         * Set the addon if there is
         * one contextually available.
         *
         * @var Addon $addon
         */
        if ($addon = $this->getAddon()) {
            $migration->setAddon($addon);
        }

        $this->dispatch(new Migrate($migration));

        parent::runUp($file, $batch, $pretend);
    }

    /**
     * Run "down" a migration instance.
     *
     * @param  string $file
     * @param  object $migration
     * @param  bool   $pretend
     * @return void
     */
    protected function runDown($file, $migration, $pretend)
    {
        /**
         * Run our migrations first.
         *
         * @var Migration $migration
         */
        $migration = $this->resolve($file);

        /**
         * Set the addon if there is
         * one contextually available.
         *
         * @var Addon $addon
         */
        if ($addon = $this->getAddon()) {
            $migration->setAddon($addon);
        }

        $this->dispatch(new Reset($migration));

        parent::runDown($file, $migration, $pretend);
    }

    /**
     * Resolve a migration instance from a file.
     *
     * @param  string $file
     * @return object
     */
    public function resolve($file)
    {
        $migration = app((new MigrationName($file))->className());

        $migration->migration = (new MigrationName($file))->migration();

        return $migration;
    }

    /**
     * Set the addon.
     *
     * @param Addon $addon
     */
    public function setAddon(Addon $addon)
    {
        $this->addon = $addon;

        return $this;
    }

    /**
     * Get the addon.
     *
     * @return Addon
     */
    public function getAddon()
    {
        return $this->addon;
    }
}
