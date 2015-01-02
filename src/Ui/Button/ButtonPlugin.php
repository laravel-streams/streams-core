<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

class ButtonPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var ButtonPluginFunctions
     */
    protected $functions;

    /**
     * Create a new UiPlugin instance.
     *
     * @param ButtonPluginFunctions $functions
     */
    public function __construct(ButtonPluginFunctions $functions)
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
            new \Twig_SimpleFunction('buttons', [$this->functions, 'buttons']),
        ];
    }
}
