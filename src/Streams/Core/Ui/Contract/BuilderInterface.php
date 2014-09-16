<?php namespace Streams\Core\Ui\Contract;

interface BuilderInterface
{
    /**
     * Set the options array.
     *
     * @return array
     */
    public function setOptions($options);

    /**
     * Return data.
     *
     * @return array
     */
    public function data();
}