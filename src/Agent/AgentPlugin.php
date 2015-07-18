<?php namespace Anomaly\Streams\Platform\Agent;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Mobile_Detect;

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
     * @var Mobile_Detect
     */
    protected $agent;

    /**
     * Create a new AgentPlugin instance.
     *
     * @param Mobile_Detect $agent
     */
    public function __construct(Mobile_Detect $agent)
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
            new \Twig_SimpleFunction('agent_device', [$this->agent, 'device']),
            new \Twig_SimpleFunction('agent_browser', [$this->agent, 'browser']),
            new \Twig_SimpleFunction('agent_platform', [$this->agent, 'platform']),
            new \Twig_SimpleFunction('agent_is_robot', [$this->agent, 'isRobot']),
            new \Twig_SimpleFunction('agent_is_mobile', [$this->agent, 'isMobile']),
            new \Twig_SimpleFunction('agent_is_desktop', [$this->agent, 'isDesktop']),
        ];
    }
}
