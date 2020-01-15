<?php

namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

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
            function (ButtonInterface $button) {
                return $button->isEnabled();
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
            function (ButtonInterface $button) {
                return $button->isPrimary();
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
            function (ButtonInterface $button) {
                return !$button->isPrimary();
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
        return view('theme::buttons/buttons', ['buttons' => $this->items])->render();
    }
}
