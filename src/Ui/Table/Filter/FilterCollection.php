<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FilterInterface;
use Illuminate\Support\Collection;

/**
 * Class FilterCollection
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterCollection extends Collection
{

    /**
     * Return the active filter.
     *
     * @return static
     */
    public function active()
    {
        $active = [];

        foreach ($this->items as $item) {
            if ($this->filterIsActive($item)) {
                $active[] = $item;
            }
        }

        return self::make($active);
    }

    /**
     * Return whether the filter is active or not.
     *
     * @param FilterInterface $item
     * @return mixed
     */
    protected function filterIsActive(FilterInterface $item)
    {
        return $item->isActive();
    }
}
