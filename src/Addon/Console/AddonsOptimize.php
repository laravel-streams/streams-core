<?php

namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonOptimizer;
use Illuminate\Console\Command;

/**
 * Class AddonsOptimize
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonsOptimize extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addons:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize addons.';

    /**
     * Execute the console command.
     *
     * @param AddonOptimizer $optimizer
     */
    public function handle(AddonOptimizer $optimizer)
    {
        $optimizer->optimize();

        $this->info('Addons optimized.');
    }
}
