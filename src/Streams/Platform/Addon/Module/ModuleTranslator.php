<?php namespace Streams\Platform\Addon\Module;

use Streams\Platform\Addon\AddonTranslator;

class ModuleTranslator extends AddonTranslator
{
    /**
     * Translate a module to it's tag.

     *
*@param Module $module
     * @return bool|mixed|string
     */
    public function toTag(Module $module)
    {
        return $this->translate($module, 'Tag');
    }

    /**
     * Translate a module to it's installer.

     *
*@param Module $module
     * @return bool|string
     */
    public function toInstaller(Module $module)
    {
        return $this->translate($module, 'Installer');
    }
}
 