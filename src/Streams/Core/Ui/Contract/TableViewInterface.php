<?php namespace Streams\Core\Ui\Contract;

interface TableViewInterface
{
    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive();

    /**
     * Set the active state.
     *
     * @param $flag
     * @return mixed
     */
    public function setActive($state);

    /**
     * Get an option value or the default.
     *
     * @param      $option
     * @param null $default
     * @return mixed
     */
    public function getOption($option, $default = null);
}