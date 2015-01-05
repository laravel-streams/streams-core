<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class FormPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var FormPluginFunctions
     */
    protected $functions;

    /**
     * Create a new FormPlugin instance.
     *
     * @param FormPluginFunctions $functions
     */
    public function __construct(FormPluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Return available form plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('form_toolbar', [$this->functions, 'toolbar']),
            new \Twig_SimpleFunction('form_layout', [$this->functions, 'layout']),
            new \Twig_SimpleFunction('form_controls', [$this->functions, 'controls']),
            new \Twig_SimpleFunction('form_section', [$this->functions, 'section']),
            new \Twig_SimpleFunction('form_field', [$this->functions, 'field']),
        ];
    }
}
