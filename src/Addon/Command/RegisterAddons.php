<?php namespace Anomaly\Streams\Platform\Addon\Command;

use Anomaly\Streams\Platform\Addon\AddonManager;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class RegisterAddons
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class RegisterAddons implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param AddonManager $manager
     */
    public function handle(AddonManager $manager)
    {
        $manager->register();
    }
}
