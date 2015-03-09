<?php namespace Anomaly\Streams\Platform\Agent;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Jenssegers\Agent\Agent;

/**
 * Class AgentPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Agent
 */
class AgentPlugin extends Plugin
{

    /**
     * The agent utility.
     *
     * @var Agent
     */
    protected $agent;

    /**
     * Create a new AgentPlugin instance.
     *
     * @param Agent $agent
     */
    public function __construct(Agent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('agent_device', [$this, 'device']),
            new \Twig_SimpleFunction('agent_browser', [$this, 'browser']),
            new \Twig_SimpleFunction('agent_version', [$this, 'version']),
            new \Twig_SimpleFunction('agent_platform', [$this, 'platform']),
            new \Twig_SimpleFunction('agent_is_robot', [$this, 'isRobot']),
            new \Twig_SimpleFunction('agent_is_mobile', [$this, 'isMobile']),
            new \Twig_SimpleFunction('agent_is_desktop', [$this, 'isDesktop']),
        ];
    }
}
