<?php namespace Anomaly\Streams\Platform\Stream\Console\Event;

use Illuminate\Console\Command;

/**
 * Class StreamsIsRefreshing
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StreamsIsRefreshing
{

    /**
     * The console command.
     *
     * @var Command
     */
    private $command;

    /**
     * Create a new StreamsIsRefreshing instance.
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
