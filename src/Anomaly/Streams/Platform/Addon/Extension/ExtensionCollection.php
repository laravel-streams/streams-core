<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\AddonCollection;

class ExtensionCollection extends AddonCollection
{

    public function find($key)
    {
        $matches = [];

        list($namespace, $extension) = explode('::', $key);

        list($addonType, $addonSlug) = explode('.', $namespace);

        if ($extension != '*') {

            list($extensionSlug, $extensionType) = explode('.', $extension);
        } else {
            $extensionType = '*';
            $extensionSlug = '*';
        }

        foreach ($this->items as $item) {

            $slug = $item->getSlug();

            if (starts_with($slug, "{$addonSlug}_{$addonType}_")) {

                if ($extensionType == '*' and $extensionSlug == '*') {

                    $matches[] = $item;
                } elseif ($extensionSlug == '*' and ends_with($slug, "_{$extensionType}")) {

                    $matches[] = $item;
                } elseif (ends_with($slug, "_{$addonSlug}_{$addonType}")) {

                    $matches[] = $item;
                }
            }
        }

        return $matches;
    }
}
 