<?php

namespace Streams\Core\View;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

class ViewIncludes extends Collection
{

    public function include(
        string $slot,
        string $name,
        string $include = null
    ): ViewIncludes {

        $this->slot($slot)->put($name, $include ?: $name);

        return $this;
    }

    public function slot(string $slot): Collection
    {
        if (!$this->has($slot)) {
            $this->put($slot, new Collection());
        }

        return $this->get($slot);
    }

    public function render($slot, array $payload = [])
    {
        return $this->get($slot, new Collection())
            ->map(function ($include) use ($payload) {
                return View::make($include, $payload)->render();
            })->implode('');
    }
}
