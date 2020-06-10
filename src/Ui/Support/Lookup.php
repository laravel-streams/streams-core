<?php

namespace Anomaly\Streams\Platform\Ui\Support;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;

/**
 * Registry merger (lookup).
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Lookup
{

    /**
     * Merge buttons.
     *
     * @param array $buttons
     * @return array
     */
    public static function buttons(array $buttons)
    {
        /* @var ButtonRegistry $registry */
        $registry = app(ButtonRegistry::class);

        foreach ($buttons as &$parameters) {

            if (!$button = Arr::get($parameters, 'button')) {
                continue;
            }

            if ($button && $lookup = $registry->get($button)) {
                $parameters = array_replace_recursive($lookup, $parameters);
            }

            $button = Arr::get($parameters, 'button', $button);

            if ($button && $lookup = $registry->get($button)) {
                $parameters = array_replace_recursive($lookup, $parameters);
            }
        }

        return $buttons;
    }
}
