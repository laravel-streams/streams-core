<?php namespace Streams\Core\Addon\Presenter;

use Streams\Core\Addon\ModuleAbstract;
use Streams\Core\Addon\Collection\ModuleSectionCollection;

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
