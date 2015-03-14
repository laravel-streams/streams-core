<?php namespace Anomaly\Streams\Platform\Addon\Command;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class RegisterAddons
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Command
 */
class RegisterAddons implements SelfHandling
{

    /**
     * Register all addons.
     *
     * @param AddonManager $manager
     */
    public function handle(AddonManager $manager)
    {
        $manager->register();
    }
}
