<?php namespace Anomaly\Streams\Platform\Database\Seeder\Command;

use Illuminate\Console\Command;

/**
 * Class Seed
 *
 * @package Anomaly\Streams\Platform\Database\Seeder\consoleCommand
 */
class Seed
{

    /**
     * @var string
     */
    protected $addonNamespace;

    /**
     * @var null
     */
    protected $class;

    /**
     * @var Command
     */
    protected $consoleCommand;

    /**
     * @param         $addonNamespace
     * @param null    $class
     * @param Command $consoleCommand
     */
    public function __construct(
        $addonNamespace,
        $class = null,
        Command $consoleCommand = null
    ) {
        $this->addonNamespace = $addonNamespace;
        $this->class = $class;
        $this->consoleCommand = $consoleCommand;
    }

    /**
     * @return string
     */
    public function getAddonNamespace()
    {
        return $this->addonNamespace;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return Command
     */
    public function getConsoleCommand()
    {
        return $this->consoleCommand;
    }

}
