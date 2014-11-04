<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Tag\TagAddon;

class ModuleTag extends TagAddon
{

    protected $module;

    function __construct(Module $module)
    {
        $this->module = $module;
    }

    public function name()
    {
        return $this->module->toPresenter()->name;
    }
}
 