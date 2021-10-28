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

    /**
     * @param string|null $handle
     * @return Application
     */
    public function make(string $handle = null)
    {
        return $this->collection->get($handle ?: $this->active);
    }

    /**
     * @param Application|Entry $active
     */
    public function activate($active): void
    {
        $this->active = $active->id;

        $this->collection->put($this->active, $active);
    }

    /**
     * @return Application|Entry
     */
    public function active()
    {
        return $this->collection->get($this->active);
    }

    public function collection(): Collection
    {
        return $this->collection;
    }
}
