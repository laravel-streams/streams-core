<?php namespace Streams\Platform\Addon;

class AddonTranslator
{
    /**
     * Translate an addon to its service provider.
     *
     * @param AddonAbstract $addon
     * @return bool|string
     */
    public function toServiceProvider(AddonAbstract $addon)
    {
        $class      = get_class($addon);
        $translated = $class . 'ServiceProvider';

        if (!class_exists($translated)) {
            return false;
        }

        return $translated;
    }
}
 