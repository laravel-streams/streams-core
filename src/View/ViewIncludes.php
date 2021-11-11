<?php

namespace Streams\Core\View;

use Illuminate\Support\Collection;

class ViewIncludes extends Collection
{

    public function include(string $slot, string $include): ViewIncludes
    {
        $this->slot($slot)->put($include, $include);

        return $this;
    }

    public function slot(string $slot): Collection
    {
        if (!$this->has($slot)) {
            $this->put($slot, new Collection());
        }

        return $this->get($slot);
    }
}
