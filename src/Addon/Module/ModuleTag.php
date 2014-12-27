<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Tag\Plugin;

/**
 * Class ModulePlugin
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Module
 */
class ModulePlugin extends Plugin
{

    /**
     * The module object.
     *
     * @var Module
     */
    protected $module;

    /**
     * Create a new ModulePlugin instance.
     *
     * @param Module $module
     */
    public function __construct(Module $module)
    {
        $this->module = $module;
    }

    /**
     * Return the module name.
     *
     * @return mixed
     */
    public function name()
    {
        return trans($this->module->getName());
    }
}
