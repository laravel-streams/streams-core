<?php

namespace Streams\Core\Asset\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Console\Kernel;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Streams\Core\StreamsServiceProvider;
use Streams\Core\Application\Application;

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
        $console->call('vendor:publish', ['--tag' => 'assets', '--provider' => StreamsServiceProvider::class, '--force' => true]);

        foreach (app('streams.addons')->keys() as $namespace) {

            $parts = array_map(
                function ($value) {
                    return Str::slug(strtolower($value), '_');
                },
                explode('.', $namespace)
            );

            array_walk($parts, function (&$part) {
                $part = ucfirst(Str::camel($part));
            });

            $parts[1] = $parts[2] . $parts[1];
            $parts[2] = $parts[1] . 'ServiceProvider';

            $provider = implode("\\", $parts);

            $console->call('vendor:publish', ['--tag' => 'assets', '--provider' => $provider, '--force' => true]);
        }

        $this->info('Addon assets have been published!');
    }
}
