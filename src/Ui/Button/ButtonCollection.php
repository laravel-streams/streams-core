<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;
use Illuminate\Support\Collection;

/**
 * Class ButtonCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Button
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
        $enabled = [];

        foreach ($this->items as $item) {
            if ($item instanceof ButtonInterface && $item->isEnabled()) {
                $enabled[] = $item;
            }
        }

        return new static($enabled);
    }
}
