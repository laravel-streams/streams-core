<?php namespace Streams\Core\Support;

use Streams\Core\Contract\PresenterInterface;

class Decorator
{
    /**
     * Decorate a value.
     *
     * @param mixed $atom
     * @return mixed
     */
    public function decorate($value)
    {
        if ($value instanceof PresenterInterface) {
            return $value->newPresenter($value);
        }

        return $value;
    }
}