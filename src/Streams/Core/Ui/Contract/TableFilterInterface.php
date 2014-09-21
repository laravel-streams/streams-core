<?php namespace Streams\Platform\Ui\Contract;

interface TableFilterInterface
{
    /**
     * Return the filter input.
     *
     * @return string
     */
    public function input();

    /**
     * Build onto the query.
     *
     * @param $query
     * @return mixed
     */
    public function query($query);
}