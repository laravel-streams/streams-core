<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Tag\Tag;

class ModuleTag extends Tag
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
 