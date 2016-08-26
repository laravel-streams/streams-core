<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\MigrationName;
use Anomaly\Streams\Platform\Database\Migration\Command\Migrate;
use Anomaly\Streams\Platform\Database\Migration\Command\Rollback;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

class Migrator extends \Illuminate\Database\Migrations\Migrator
{
    use DispatchesJobs;

    /**
     * The addon instance.
     *
     * @var Addon
     */
    protected $addon  = null;

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

        $this->dispatch(new Rollback($migration));

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
        return app((new MigrationName($file))->className());
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
