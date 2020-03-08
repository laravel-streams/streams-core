<?php

namespace Anomaly\Streams\Platform\Http\Controller;

use Anomaly\Streams\Platform\Http\Middleware\BuildControlPanel;
use Anomaly\Streams\Platform\Http\Middleware\DetectActiveModule;

/**
 * Class AdminController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AdminController extends BaseController
{

    /**
     * Create a new AdminController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(DetectActiveModule::class);
        $this->middleware(BuildControlPanel::class);
    }
}
