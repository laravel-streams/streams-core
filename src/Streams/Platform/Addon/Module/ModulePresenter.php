<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonPresenter;

class ModulePresenter extends AddonPresenter
{
    /**
     * Create a new ModulePresenter instance.
     *
     * @param null $resource
     */
    public function __construct(ModuleAbstract $resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * Return the sections for a module.
     *
     * @return ModuleSectionCollection
     */
    public function sections()
    {
        return new ModuleSectionCollection($this->resource->getSections());
    }
}
