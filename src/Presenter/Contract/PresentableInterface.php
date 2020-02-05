<?php

namespace Anomaly\Streams\Platform\Presenter\Contract;

use Anomaly\Streams\Platform\Support\Presenter;

interface PresentableInterface
{
    /**
     * Return a new presenter.
     *
     * @return Presenter
     */
    public function newPresenter();
}
