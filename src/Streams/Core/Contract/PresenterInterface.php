<?php namespace Streams\Core\Contract;

interface PresenterInterface
{
    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return \Streams\Presenter\PresenterAbstract
     */
    public function newPresenter($resource);
}
