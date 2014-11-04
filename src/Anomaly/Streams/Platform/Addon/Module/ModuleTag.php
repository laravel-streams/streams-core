<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Tag\TagAddon;

class ModuleTag extends TagAddon
{

    protected $module;

    function __construct(ModuleAddon $module)
    {
        $this->module = $module;
    }

    public function name()
    {
        return 'Test';
        $this->module->toPresenter()->name;
    }
}
 