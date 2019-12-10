<?php

namespace Anomaly\Streams\Platform\Application\Event;

use Illuminate\Console\Command;

/**
 * Class SystemHasBuilt
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SystemHasBuilt
{

    /**
     * The command instance.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new SystemHasBuilt instance.
     *
     * @param Command $command
     */
    public function __construct(Command $command)
    {
        $this->command = $command;
    }

    /**
     * Get the command.
     *
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
    }
}
