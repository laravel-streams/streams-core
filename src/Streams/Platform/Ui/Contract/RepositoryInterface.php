<?php namespace Streams\Platform\Ui\Contract;

interface RepositoryInterface
{
    /**
     * Return a collection of entries.
     *
     * @return mixed
     */
    public function get();

    /**
     * Return a single entry.
     *
     * @param $id
     * @return mixed
     */
    public function find($id);
}