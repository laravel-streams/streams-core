<?php

namespace Streams\Core\Application;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Streams\Core\Application\Application;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Support\Traits\HasMemory;

/**
 * Class ApplicationManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ApplicationManager
{

    use HasMemory;

    /**
     * The application collection.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * The active application.
     *
     * @var null|string
     */
    protected $active = null;

    public function __construct()
    {
        $this->collection = Streams::repository('core.applications')->all();
    }

    /**
     * Make an application instance.
     *
     * @param string|null $handle
     * @return Application
     */
    public function make($handle = null)
    {
        return App::make('streams.applications.' . ($handle ?: $this->active));
    }

    /**
     * Return the active application.
     *
     * @return Application
     */
    public function active($active = null)
    {
        if (is_object($active)) {
            $active = $active->id;
        }
        
        if ($active) {
            $this->active = $active;
        }

        return $this->collection->get($this->active);
    }

    /**
     * Switch the application.
     *
     * @todo does this work?
     *
     * @param string|null $handle
     */
    public function activate($handle = 'default')
    {
        $this->active = $handle;
    }

    /**
     * Return the collection instance.
     * 
     * @return Collection
     */
    public function collection()
    {
        return $this->collection;
    }
}
