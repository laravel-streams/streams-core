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
        return [];
    }
}
