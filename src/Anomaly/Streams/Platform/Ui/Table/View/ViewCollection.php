<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Illuminate\Support\Collection;

class ViewCollection extends Collection
{

    public function active()
    {
        foreach ($this->items as $item) {

            if ($item->isActive()) {

                return $item;
            }
        }

        return null;
    }
}
 