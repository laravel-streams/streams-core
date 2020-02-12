<?php

namespace Anomaly\Streams\Platform\Traits;

use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class Presentable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Presentable
{

    /**
     * Get the presenter.
     * 
     * return string
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * Return a new presenter instance.
     * 
     * @return Presenter
     */
    public function newPresenter()
    {
        return app($this->getPresenter(), ['object' => $this]);
    }

    /**
     * Return the decorated object.
     */
    public function decorate()
    {
        return is_object($this->presenter) ? $this->presenter : $this->newPresenter();
    }
}
