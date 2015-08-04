<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class UiPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class UiPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var UiPluginFunctions
     */
    protected $functions;

    /**
     * Create a new UiPlugin instance.
     *
     * @param UiPluginFunctions $functions
     */
    public function __construct(UiPluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Return UI functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('icon', [$this->functions, 'icon'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('buttons', [$this->functions, 'buttons'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('elapsed', [$this->functions, 'elapsed'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('constants', [$this->functions, 'constants'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('footprint', [$this->functions, 'footprint'], ['is_safe' => ['html']])
        ];
    }
}
