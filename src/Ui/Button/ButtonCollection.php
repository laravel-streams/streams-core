<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Support\Collection;
use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonInterface;

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
        return $this->filter(
            function (ButtonInterface $button) {
                return $button->isEnabled();
            }
        );
    }
}
