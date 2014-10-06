<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\Addon;

class ModuleAddon extends Addon
{
    protected $type = 'module';

    protected $nav = null;

    protected $menu = [];

    protected $sections = [];

    protected $installed = false;

    protected $enabled = false;

    public function getNav()
    {
        return $this->nav;
    }

    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    public function getMenu()
    {
        return $this->menu;
    }

    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
    }

    public function getSections()
    {
        return $this->sections;
    }

    public function getActiveSection()
    {
        foreach ($this->sections as $section) {
            if (strpos($_SERVER['REQUEST_URI'], $section['url']) !== false) {
                return $section;
            }
        }

        return null;
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
        return $this->enabled;
    }

    public function newTag()
    {
        return new ModuleTag($this->app);
    }

    public function newModel()
    {
        return new ModuleModel();
    }

    public function newPresenter()
    {
        return new ModulePresenter($this);
    }

    public function newInstaller()
    {
        return new ModuleInstaller();
    }

    public function newServiceProvider()
    {
        return new ModuleServiceProvider($this->app);
    }
}
