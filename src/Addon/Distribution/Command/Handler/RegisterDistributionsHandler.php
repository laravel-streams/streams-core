<?php namespace Anomaly\Streams\Platform\Addon\Distribution\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonManager;

/**
 * Class RegisterDistributionsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution\Command
 */
class RegisterDistributionsHandler
{

    /**
     * The addon manager.
     *
     * @var AddonManager
     */
    protected $manager;

    /**
     * Create a new RegisterDistributionsHandler instance.
     *
     * @param AddonManager $manager
     */
    public function __construct(AddonManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->manager->register('distribution');
    }
}
