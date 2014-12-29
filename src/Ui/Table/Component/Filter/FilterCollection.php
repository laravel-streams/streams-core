<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FilterInterface;
use Illuminate\Support\Collection;

/**
 * Class FilterCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterCollection extends Collection
{

    /**
     * Return a collection of active filters.
     *
     * @return static
     */
    public function active()
    {
        $active = [];

        foreach ($this->items as $item) {
            if ($item instanceof FilterInterface && $item->isActive()) {
                $active[] = $item;
            }
        }

        return self::make($active);
    }
}
