<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonTranslator;

class ModuleTranslator extends AddonTranslator
{
    /**
     * Translate a module to it's tag.
     *
     * @param ModuleAbstract $module
     * @return bool|mixed|string
     */
    public function toTag(ModuleAbstract $module)
    {
        return $this->translate($module, 'Tag');
    }

    /**
     * Translate a module to it's installer.
     *
     * @param ModuleAbstract $module
     * @return bool|string
     */
    public function toInstaller(ModuleAbstract $module)
    {
        return $this->translate($module, 'Installer');
    }
}
 