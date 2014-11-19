<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Tag\Tag;

/**
 * Class ModuleTag
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Module
 */
class ModuleTag extends Tag
{

    /**
     * The module object.
     *
     * @var Module
     */
    protected $module;

    /**
     * Create a new ModuleTag instance.
     *
     * @param Module $module
     */
    function __construct(Module $module)
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
 