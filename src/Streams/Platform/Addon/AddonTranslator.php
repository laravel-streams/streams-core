<?php namespace Streams\Platform\Addon;

class AddonTranslator
{
    /**
     * Translate an addon to it's service provider.
     *
     * @param AddonAbstract $addon
     * @return bool|string
     */
    public function toServiceProvider(AddonAbstract $addon)
    {
        return $this->translate($addon, 'ServiceProvider');
    }

    /**
     * Translate an addon to a class.
     *
     * @param $addon
     * @param $class
     * @return bool|string
     */
    protected function translate($addon, $class)
    {
        $addonClass = get_class($addon);
        $translated = $addonClass . $class;

        if (!class_exists($translated)) {
            return false;
        }

        return $translated;
    }
}
 