<?php namespace Streams\Core\Traits;

trait ObservableTrait
{
    /**
     * Set the observer class to use.
     *
     * @param $observer
     * @return $this
     */
    public function setObserver($observer)
    {
        $this->observer = $observer;

        return $this;
    }

    /**
     * Get the observer class.
     *
     * @return string
     */
    public function getObserver()
    {
        return $this->observer;
    }
}
