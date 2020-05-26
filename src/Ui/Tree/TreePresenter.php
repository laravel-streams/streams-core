<?php

namespace Anomaly\Streams\Platform\Ui\Tree;

use Illuminate\View\View;
use Illuminate\View\Factory;
use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class TreePresenter
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TreePresenter extends Presenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var Tree
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
