<?php namespace Anomaly\Streams\Platform\Ui\Form\Redirect;

use Illuminate\Support\Collection;

class RedirectCollection extends Collection
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
 