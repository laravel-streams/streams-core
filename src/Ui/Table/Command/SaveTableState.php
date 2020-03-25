<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

/**
 * Class SaveTableState
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SaveTableState
{

    /**
     * @param Store   $session
     * @param Request $request
     */
    public function handle(Store $session, Request $request)
    {
        $session->put('table::' . $request->url(), $request->getQueryString());
    }
}
