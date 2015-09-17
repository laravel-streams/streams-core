<?php

namespace Anomaly\Streams\Platform\Database\Seeder\Command;

use Illuminate\Console\Command;

/**
 * Class Seed.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Seeder\Command
 */
class Seed
{
    /**
     * The seeder class to run.
     *
     * @var null
     */
    protected $class;

    /**
     * The addon namespace.
     *
     * @var string
     */
    protected $addon;

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new Seed instance.
     *
     * @param         $addon
     * @param null    $class
     * @param Command $consoleCommand
     */
    public function __construct($addon, $class = null, Command $command = null)
    {
        $this->addon   = $addon;
        $this->class   = $class;
        $this->command = $command;
    }

    /**
     * Get the addon namespace.
     *
     * @return string
     */
    public function getAddon()
    {
        return $this->addon;
    }

    /**
     * Get the seeder class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Get the console command.
     *
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }
}
