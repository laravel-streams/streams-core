<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Console\Command\PublishConfig;
use Anomaly\Streams\Platform\Addon\Console\Command\PublishTranslations;
use Anomaly\Streams\Platform\Addon\Console\Command\PublishViews;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class AddonPublish
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonPublish extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addon:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish an the configuration and translations for an addon.';

    /**
     * Execute the console command.
     */
    public function handle(AddonCollection $addons)
    {
        $addon = $this->argument('addon');

        $parts = addon_map($addon);

        array_walk($parts, function (&$part) {
            $part = ucfirst(camel_case($part));
        });

        $parts[2] = $parts[2] . $parts[1] . 'ServiceProvider';

        //$provider = str_replace('\\', '\\\\', implode("\\", $parts));
        $provider = implode("\\", $parts);

        $this->call('vendor:publish', ['--tag' => 'public', '--provider' => $provider]);
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['addon', InputArgument::REQUIRED, 'The addon to publish.'],
        ];
    }

    /**
     * Get the command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Overwrite files.'],
        ];
    }
}
