<?php namespace Anomaly\Streams\Platform\Addon\Extension;

use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class ExtensionCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\Extension
 */
class ExtensionCollection extends AddonCollection
{
    
    public function find($pattern)
    {
        $matches = [];

        list($namespace, $extension) = explode('::', $pattern);

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

        return self::make($matches);
    }

    public function prioritized()
    {
        $expidited = [];
        $normal    = [];
        $deferred  = [];

        foreach ($this->items as $item) {

            if ($this->isExpedited()) {

                $expidited[] = $item;
            } elseif ($this->isDeferred()) {

                $deferred[] = $item;
            } else {

                $normal[] = $item;
            }
        }

        return self::make($expidited + $normal + $deferred);
    }
}
