<?php

namespace Anomaly\Streams\Platform\Ui\Grid;

use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class GridPresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GridPresenter extends Presenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var Grid
     */
    protected $object;

    /**
     * Display the form content.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->object
            ->render()
            ->render();
    }
}
