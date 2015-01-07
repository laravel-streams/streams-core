<?php namespace Anomaly\Streams\Platform\Addon\Distribution;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class DistributionPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Distribution
 */
class DistributionPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var DistributionPluginFunctions
     */
    protected $functions;

    /**
     * Create a new DistributionPlugin instance.
     *
     * @param DistributionPluginFunctions $functions
     */
    public function __construct(DistributionPluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Return plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('distribution', [$this->functions, 'distribution']),
        ];
    }
}
