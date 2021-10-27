<?php

namespace Streams\Core\Application;

use Illuminate\Support\Collection;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;

class ApplicationManager
{

    use HasMemory;

    protected Collection $collection;

    protected string $active = '';

    public function __construct()
    {
        $this->collection = Streams::entries('core.applications')->get()
            ->keyBy(function ($item) {
                return $item->id;
            });
    }

    public function make(string $handle = null): Application
    {
        return $this->collection->get($handle ?: $this->active);
    }

    public function activate(Application $active): void
    {
        $this->active = $active->id;

        $this->collection->put($this->active, $active);
    }

    public function active(): Application
    {
        return $this->collection->get($this->active);
    }

    public function collection(): Collection
    {
        return $this->collection;
    }
}
