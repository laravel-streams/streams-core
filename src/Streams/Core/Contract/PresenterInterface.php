<?php namespace Streams\Core\Contract;

interface PresenterInterface
{
    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return mixed
     */
    public function newPresenter($resource);
}
