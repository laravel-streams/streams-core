<?php namespace Anomaly\Streams\Platform\Addon\Plugin\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonManager;

/**
 * Class RegisterPluginsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class RegisterPluginsHandler
{

    /**
     * The addon manager.
     *
     * @var AddonManager
     */
    protected $manager;

    /**
     * Create a new RegisterPluginsHandler instance.
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
        $this->manager->register('plugin');
    }
}
