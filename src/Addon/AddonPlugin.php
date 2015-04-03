<?php namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class AddonPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonPlugin extends Plugin
{

    /**
     * The addon plugins.
     *
     * @var AddonPluginFunctions
     */
    protected $functions;

    /**
     * Create a new AddonPlugin instance.
     *
     * @param AddonPluginFunctions $functions
     */
    public function __construct(AddonPluginFunctions $functions)
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
            new \Twig_SimpleFunction('modules', [$this->functions, 'modules'])
        ];
    }
}
