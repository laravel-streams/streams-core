<?php

namespace Anomaly\MakerExtension\Console;

use Anomaly\Streams\Platform\Addon\AddonOptimizer;
use Illuminate\Console\Command;

/**
 * Class AddonsClear
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonsClear extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addons:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear addons cache.';

    /**
     * Handle the command.
     *
     * @return void
     */
    public function handle()
    {
        if (file_exists($file = base_path('bootstrap/cache/addons.php'))) {
            unlink($file = base_path('bootstrap/cache/addons.php'));
        }

        $this->info('Addons cache cleared.');
    }
}
