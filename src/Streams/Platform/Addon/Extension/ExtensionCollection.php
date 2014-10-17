<?php namespace Streams\Platform\Addon\Extension;

use Streams\Platform\Addon\AddonCollection;

class ExtensionCollection extends AddonCollection
{
    public function find($key)
    {
        $matches = [];

        list($namespace, $extension) = explode('::', $key);

        list($addonType, $addonSlug) = explode('.', $namespace);

        if ($extension != '*') {

            list($extensionType, $extensionSlug) = explode('.', $extension);

        } else {
            $extensionType = '*';
            $extensionSlug = '*';
        }

        foreach ($this->items as $item) {

            list($itemAddonSlug, $itemAddonType, $itemExtensionSlug, $itemExtensionType) = explode('_', $item->slug);

            if ($addonType == $itemAddonType and $addonSlug == $itemAddonSlug) {

                if ($extensionType == '*' and $extensionSlug == '*') {

                    $matches[] = $item;

                } elseif ($extensionSlug == '*' and $extensionType == $itemExtensionType) {

                    $matches[] = $item;

                } elseif ($extensionSlug == $itemExtensionSlug and $extensionType == $itemExtensionType) {

                    $matches[] = $item;

                }

            }

        }

        return $matches;
    }
}
 