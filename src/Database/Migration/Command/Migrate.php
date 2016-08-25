<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class Migrate
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class Migrate
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new Migrate instance.
     *
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * Handle the command.
     *
     * @param Migrate $command
     */
    public function handle()
    {
        $this->migration->createFields();
        $this->migration->createStream();
        $this->migration->assignFields();
    }
}
