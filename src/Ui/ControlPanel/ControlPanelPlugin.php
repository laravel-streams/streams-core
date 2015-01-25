<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class ControlPanelPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel
 */
class ControlPanelPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var ControlPanelPluginFunctions
     */
    protected $functions;

    /**
     * Create a new ControlPanelPlugin instance.
     *
     * @param ControlPanelPluginFunctions $functions
     */
    public function __construct(ControlPanelPluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cp_sections', [$this->functions, 'sections']),
            new \Twig_SimpleFunction('cp_buttons', [$this->functions, 'buttons']),
        ];
    }
}
