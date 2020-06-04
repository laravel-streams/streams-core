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
     * Return the active action.
     *
     * @return null|Action
     */
    public function active()
    {
        return $this->filter(function ($item) {
            return $item->active;
        });
    }
}
