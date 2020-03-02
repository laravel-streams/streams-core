<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Anomaly\Streams\Platform\Addon\AddonManager;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class AddonReinstall
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonReinstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addon:reinstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reinstall an addon.';

    /**
     * Execute the console command.
     *
     * @param AddonManager $manager
     */
    public function handle(AddonManager $manager)
    {
        $addon = app($this->argument('addon'));

        $options = [
            'addon' => $this->argument('addon'),
        ];

        Artisan::call('addon:uninstall', $options);

        $options['--seed'] = $addon->getPath('migrations');

        Artisan::call('addon:install', $options);

        $this->info('Addon [' . $this->argument('addon') . '] was reinstalled.');
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['addon', InputArgument::OPTIONAL, 'The addon to reinstall.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['seed', null, InputOption::VALUE_NONE, 'Seed the addon after installing?'],
        ];
    }
}
