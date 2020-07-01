<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Illuminate\Console\Command;
use Anomaly\Streams\Platform\Addon\AddonManager;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class AddonSeed
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonSeed extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addon:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed an addon.';

    /**
     * Handle the command.
     *
     * @param AddonManager $manager
     */
    public function handle(AddonManager $manager)
    {
        $addon = app($this->argument('addon'));

        // php artisan migrate:reset --path=TheAddonPath

        $this->info('Addon [' . $this->argument('addon') . '] was seeded.');
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['addon', InputArgument::REQUIRED, 'The addon to migrate.'],
        ];
    }
}
