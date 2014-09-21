<?php namespace Streams\Platform\Ui\Contract;

interface FormActionInterface
{
    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive();

    /**
     * Set the active flag.
     *
     * @param $active
     * @return mixed
     */
    public function setActive($active);

    /**
     * Get an option value or the default.
     *
     * @param      $option
     * @param null $default
     * @return mixed
     */
    public function getOption($option, $default = null);
}