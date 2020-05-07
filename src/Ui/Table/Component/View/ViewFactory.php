<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Table\Component\View\View;

/**
 * Class ViewFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ViewFactory
{

    /**
     * The default view class.
     *
     * @var string
     */
    protected $view = View::class;

    /**
     * Make a view.
     *
     * @param  array         $parameters
     * @return View
     */
    public function make(array $parameters)
    {
        if (!class_exists(array_get($parameters, 'view'))) {
            array_set($parameters, 'view', $this->view);
        }

        Hydrator::hydrate(
            $view = App::make(array_get($parameters, 'view'), $parameters),
            $parameters
        );

        return $view;
    }
}
