<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Illuminate\Support\Collection;

class FilterCollection extends Collection
{

    public function active()
    {
        $active = [];

        foreach ($this->items as $item) {

            if ($item->isActive()) {

                $active[] = $item;
            }
        }

        return self::make($active);
    }
}
 