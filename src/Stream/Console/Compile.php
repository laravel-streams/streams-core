<?php namespace Anomaly\Streams\Platform\Stream\Console;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Application\Command\ReadEnvironmentFile;
use Anomaly\Streams\Platform\Application\Command\WriteEnvironmentFile;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

/**
 * Class Compile
 *
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 *
 * @link   http://pyrocms.com/
 */
class Compile extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'streams:compile';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compile streams entry models.';

    /**
     * Execute the console command.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function fire(StreamRepositoryInterface $streams)
    {
        $wasInstalled = false;

        if ($this->option('force'))
        {
            $env = $this->dispatch(new ReadEnvironmentFile());

            $wasInstalled = array_get($env, 'INSTALLED') === 'true';

            array_set($env, 'INSTALLED', 'false');

            $this->dispatch(new WriteEnvironmentFile($env));
        }

        /* @var StreamInterface $stream */
        foreach ($streams->all() as $stream)
        {
            if ($streams->save($stream))
            {
                $this->info($stream->getEntryModelName().' compiled successfully.');
            }
        }

        if ($this->option('force') && $wasInstalled)
        {
            $env = $this->dispatch(new ReadEnvironmentFile());

            array_set($env, 'INSTALLED', 'true');

            $this->dispatch(new WriteEnvironmentFile($env));
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Force compile streams.'],
        ];
    }
}
