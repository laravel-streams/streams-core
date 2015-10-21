<?php namespace Anomaly\Streams\Platform\Application\Console;

use Anomaly\Streams\Platform\Application\Command\GenerateEnvironmentFile;
use Anomaly\Streams\Platform\Application\Command\GetEnvironmentData;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class EnvSet
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Console
 */
class EnvSet extends Command
{

    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'env:set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set an environmental value.';

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $line = $this->argument('line');

        list($variable, $value) = explode('=', $line, 2);

        $data = $this->dispatch(new GetEnvironmentData());

        array_set($data, $variable, $value);

        $this->dispatch(new GenerateEnvironmentFile($data));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['line', InputArgument::REQUIRED, 'The line to update.']
        ];
    }
}
