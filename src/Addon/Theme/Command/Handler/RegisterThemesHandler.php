<?php namespace Anomaly\Streams\Platform\Addon\Theme\Command\Handler;

use Anomaly\Streams\Platform\Addon\AddonManager;

/**
 * Class RegisterThemesHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Theme\Command
 */
class RegisterThemesHandler
{

    /**
     * The addon manager.
     *
     * @var AddonManager
     */
    protected $manager;

    /**
     * Create a new RegisterThemesHandler instance.
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
        $this->manager->register('theme');
    }
}
