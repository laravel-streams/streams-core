<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Button\Button;

/**
 * Class ButtonCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ButtonCollection extends Collection
{

    /**
     * Return only enabled buttons.
     *
     * @return ButtonCollection
     */
    public function enabled()
    {
        return $this->filter(
            function ($button) {
                return $button->enabled;
            }
        );
    }

    /**
     * Return only primary buttons.
     *
     * @return ButtonCollection
     */
    public function primary()
    {
        return $this->filter(
            function ($button) {
                return $button->primary;
            }
        );
    }

    /**
     * Return only secondary buttons.
     *
     * @return ButtonCollection
     */
    public function secondary()
    {
        return $this->filter(
            function ($button) {
                return !$button->primary;
            }
        );
    }

    /**
     * Render the actions.
     *
     * @return string
     */
    public function __toString()
    {
        return view('streams::ui/buttons/buttons', ['buttons' => $this->items->values()])->render();
    }
}
