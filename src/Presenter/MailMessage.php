<?php

namespace Anomaly\Streams\Platform\Presenter;

class Presenter
{
    /**
     * The message view.
     *
     * @var string
     */
    public $view = 'streams::notifications/email';

    /**
     * Map calls to undefined functions
     * to set public properties for later.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return $this
     */
    public function __call($method, array $arguments = [])
    {
        $this->viewData[snake_case($method)] = array_shift($arguments);

        return $this;
    }
}
