<?php namespace Anomaly\Streams\Platform\Addon\Module;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Contract\PresentableInterface;

class ModuleAddon extends Addon implements PresentableInterface
{

    protected $navigation = null;

    protected $menu = [];

    protected $sections = [];

    protected $installed = false;

    protected $enabled = false;

    protected $active = false;

    public function getNavigation()
    {
        return $this->navigation;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function setInstalled($installed)
    {
        $this->installed = $installed;

        return $this;
    }

    public function isInstalled()
    {
        return $this->installed;
    }

    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isEnabled()
    {
        return $this->enabled and $this->installed;
    }

    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function toTag()
    {
        if (!$tag = $this->transform(__METHOD__)) {

            $tag = 'Anomaly\Streams\Platform\Addon\Module\ModuleTag';
        }

        return app()->make($tag, ['module' => $this]);
    }

    public function toPresenter()
    {
        if (!$presenter = $this->transform(__METHOD__)) {

            $presenter = 'Anomaly\Streams\Platform\Addon\Module\ModulePresenter';
        }

        return app()->make($presenter, ['module' => $this]);
    }

    public function decorate()
    {
        return new ModulePresenter($this);
    }

    public function newInstaller()
    {
        return app('streams.transformer')->toInstaller($this);
    }
}
