<?php namespace Anomaly\Streams\Platform\Stream\Console;

use Anomaly\Streams\Platform\Stream\Console\Event\StreamsIsRefreshing;
use Illuminate\Console\Command;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class Refresh
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Refresh extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'streams:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh streams generated components.';

    /**
     * Execute the console command.
     *
     * @param Dispatcher $events
     */
    public function handle(Dispatcher $events)
    {
        $this->call('streams:compile');

        $events->fire(new StreamsIsRefreshing($this));
    }
}
