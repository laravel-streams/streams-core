<?php

namespace Anomaly\Streams\Platform\Application\Console;

use Illuminate\Console\Command;
use Anomaly\Streams\Platform\Support\Env;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class EnvSet
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EnvSet extends Command
{
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
    public function handle()
    {
        $line = $this->argument('line');

        list($variable, $value) = explode('=', $line, 2);

        Env::write($variable, $value);

        putenv($line);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['line', InputArgument::REQUIRED, 'The line to update.'],
        ];
    }
}
