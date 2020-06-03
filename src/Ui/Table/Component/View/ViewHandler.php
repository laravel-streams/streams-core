<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\View\View;

/**
 * Class ViewHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewHandler
{

    /**
     * Handle the view's table modification.
     *
     * @param TableBuilder  $builder
     * @param View $view
     */
    public function handle(TableBuilder $builder, View $view)
    {
        if (!$handler = $view->handler) {
            return;
        }

        //App::call($handler, compact('builder'), 'handle');
    }
}
