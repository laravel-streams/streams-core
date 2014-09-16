<?php namespace Streams\Core\Ui\Contract;

interface BuilderInterface
{
    /**
     * Set the options.
     *
     * @return array
     */
    public function setOptions($options);

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