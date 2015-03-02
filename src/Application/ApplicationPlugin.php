<?php namespace Anomaly\Streams\Platform\Application;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class ApplicationPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var ApplicationPluginFunctions
     */
    protected $functions;

    /**
     * Create a new ApplicationPlugin instance.
     *
     * @param ApplicationPluginFunctions $functions
     */
    public function __construct(ApplicationPluginFunctions $functions)
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
            new \Twig_SimpleFunction('env', [$this->functions, 'env']),
            new \Twig_SimpleFunction(
                'language_get', function () {
                return null;
            }
            ),
            new \Twig_SimpleFunction(
                'language_enabled', function () {
                return null;
            }
            )
        ];
    }
}
