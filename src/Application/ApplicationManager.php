<?php

namespace Streams\Core\Application;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;

class ApplicationManager
{

    use HasMemory;

    protected Collection $collection;

    protected ?string $active = null;

    public function __construct()
    {
        $id = Config::get('streams.core.applications_id');

        $this->collection = Streams::entries($id)->get()->keyBy('id');
    }

    public function make(string $id): Application
    {
        return $this->collection->get($id);
    }

    public function activate(Application $active): void
    {
        $this->active = $active->id;

        $this->collection->put($active->id, $active);
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
