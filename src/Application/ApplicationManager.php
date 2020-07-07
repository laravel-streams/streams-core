<?php

namespace Anomaly\Streams\Platform\Application;

use Illuminate\Support\Facades\App;

/**
 * Class ApplicationManager
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ApplicationManager
{

    /**
     * Make an application instance.
     *
     * @param string $handle
     * @return Applilcation
     */
    public function make($handle)
    {
        return App::make('streams.applications.' . $handle);
    }
}
