<?php namespace Anomaly\Streams\Platform\Contract;

interface PresentableInterface
{
    /**
     * Return a new presenter instance.
     *
     * @return mixed
     */
    public function newPresenter();
}
