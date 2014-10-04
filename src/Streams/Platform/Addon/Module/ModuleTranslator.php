<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonTranslator;

class ModuleTranslator extends AddonTranslator
{
    /**
     * Translate a module to it's tag.


*
*@param ModuleAddon $module
     * @return bool|mixed|string
     */
    public function toTag(ModuleAddon $module)
    {
        return $this->translate($module, 'Tag');
    }

    /**
     * Translate a module to it's installer.


*
*@param ModuleAddon $module
     * @return bool|string
     */
    public function toInstaller(ModuleAddon $module)
    {
        return $this->translate($module, 'Installer');
    }
}
 