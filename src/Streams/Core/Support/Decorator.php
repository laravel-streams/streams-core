<?php namespace Streams\Core\Support;

use Illuminate\Database\Eloquent\Model;
use Streams\Core\Contract\PresenterInterface;
use McCool\LaravelAutoPresenter\BasePresenter;
use McCool\LaravelAutoPresenter\PresenterDecorator;

class Decorator extends PresenterDecorator
{
    /**
     * decorate an individual class
     *
     * @param mixed $atom
     * @return mixed
     */
    protected function decorateAtom($atom)
    {
        if ($atom instanceOf Model) {
            $atom = $this->decorateRelations($atom);
        }

        if (!$atom instanceof PresenterInterface) {
            return $atom;
        }

        if ($atom instanceOf BasePresenter) {
            return $atom;
        }

        return $atom->newPresenter($atom);
    }
}