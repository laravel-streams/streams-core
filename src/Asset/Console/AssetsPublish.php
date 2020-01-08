<?php

namespace Anomaly\Streams\Platform\Asset\Console;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class AssetsPublish
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssetsPublish extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'assets:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish addon compiled public assets.';

    /**
     * Execute the console command.
     *
     * @param Filesystem  $files
     * @param Application $application
     */
    public function handle(Kernel $console)
    {
        foreach (app('addon.collection')->keys() as $namespace) {

            $parts = addon_map($namespace);

            array_walk($parts, function (&$part) {
                $part = ucfirst(camel_case($part));
            });

            $parts[1] = $parts[2] . $parts[1];
            $parts[2] = $parts[1] . 'ServiceProvider';

            $provider = implode("\\", $parts);

            $console->call('vendor:publish', ['--tag' => 'assets', '--provider' => $provider, '--force' => true]);
        }

        $this->info('Addon assets have been published!');
    }
}
