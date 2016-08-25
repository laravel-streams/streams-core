<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Migration;

class GetAddonFromMigration
{

    /**
     * Get the migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new GetAddonFromMigration instance.
     *
     * @param $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * Handle the command.
     *
     * @param  AddonCollection $addons
     * @return Addon|null
     */
    public function handle(AddonCollection $addons)
    {
        $matcher = "/(^[a-zA-Z0-9._]+?)(?=__)/";

        $reflection = new \ReflectionClass($this->migration);

        $fileName = implode('_', array_slice(explode('_', basename($reflection->getFileName())), 4));

        preg_match($matcher, $fileName, $matches);

        return $addons->get(isset($matches[1]) ? $matches[1] : null);
    }
}
