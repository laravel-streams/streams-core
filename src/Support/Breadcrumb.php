<?php

namespace Anomaly\Streams\Platform\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

/**
 * Class Breadcrumb
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Breadcrumb extends Collection
{

    /**
     * Add a breadcrumb.
     *
     * @param      $key
     * @param null $url
     */
    public function add($key, $url = null)
    {
        $this->put($key, $url);
    }

    /**
     * Put a breadcrumb into the collection.
     *
     * @param string $key
     * @param string $value
     */
    public function put($key, $value = null)
    {
        if (!$value) {
            $value = url()->current();
        }

        if (!Str::startsWith($value, 'http')) {
            $value = url($value);
        }

        parent::put($key, $value);
    }

    /**
     * Return the breadcrumb.
     *
     * @return string
     */
    public function __toString()
    {
        return View::make('streams::partials/breadcrumb')->render();
    }
}
