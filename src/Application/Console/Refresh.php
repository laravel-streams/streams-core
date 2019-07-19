<?php namespace Anomaly\Streams\Platform\Application\Console;

use Anomaly\Streams\Platform\Application\Command\ReadEnvironmentFile;
use Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile;
use Anomaly\Streams\Platform\Application\Event\SystemIsRefreshing;
use Anomaly\Streams\Platform\Console\Kernel;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

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
    protected $name = 'refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the system.';

    /**
     * Execute the console command.
     */
    public function handle(Kernel $console)
    {
        $console->call('assets:clear', [], $this->getOutput());
        $console->call('cache:clear', [], $this->getOutput());
        $console->call('view:clear', [], $this->getOutput());
        $console->call('twig:clear', [], $this->getOutput());

        event(new SystemIsRefreshing());
    }
}
