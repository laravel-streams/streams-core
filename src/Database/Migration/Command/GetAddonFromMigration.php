<?php

namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class GetAddonFromMigration.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
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
     * Get the migration.
     *
     * @return string
     */
    public function getMigration()
    {
        return $this->migration;
    }
}
