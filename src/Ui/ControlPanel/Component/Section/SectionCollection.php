<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Illuminate\Support\Collection;

/**
 * Class SectionCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
 */
class SectionCollection extends Collection
{

    /**
     * Return the active section.
     *
     * @return null|SectionInterface
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item instanceof SectionInterface && $item->isActive()) {
                return $item;
            }
        }

        return null;
    }
}
