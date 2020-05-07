<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Illuminate\Support\Collection;

/**
 * Class FilterCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
        return self::filter(function ($filter) {
            return $filter->active;
        });
    }
}
