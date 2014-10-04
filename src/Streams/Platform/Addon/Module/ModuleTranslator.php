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
        $class      = get_class($module);
        $translated = $class . 'Tag';

        if (!class_exists($translated)) {
            return false;
        }

        return $translated;
    }
}
 