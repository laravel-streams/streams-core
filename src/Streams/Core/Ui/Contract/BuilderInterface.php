<?php namespace Streams\Core\Ui\Contract;

interface BuilderInterface
{
    /**
     * Make the class.
     *
     * @return array
     */
    public function make($options);

    /**
     * Set the entry.
     *
     * @param $entry
     * @return mixed
     */
    public function setEntry($entry);

    /**
     * Return data.
     *
     * @return array
     */
    public function data();
}