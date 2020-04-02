<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Component\Button;

use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class ButtonParser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonParser
{

    /**
     * Parse the button with the entry.
     *
     * @param  array $button
     * @param        $entry
     * @return mixed
     */
    public function parser(array $button, $entry)
    {
        if (is_object($entry) && $entry instanceof Arrayable) {
            $entry = $entry->toArray();
        }

        return Str::parse($button, compact('entry'));
    }
}
