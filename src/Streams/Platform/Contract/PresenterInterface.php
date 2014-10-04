<?php namespace Streams\Platform\Contract;

interface PresenterInterface
{
    /**
     * Return a new presenter instance.
     *
     * @return mixed
     */
    public function newPresenter();
}
