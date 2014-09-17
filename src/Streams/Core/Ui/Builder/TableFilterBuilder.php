<?php namespace Streams\Core\Ui\Builder;

use Streams\Core\Ui\Contract\TableFilterInterface;

class TableFilterBuilder extends TableBuilderAbstract
{
    /**
     * The filter object.
     *
     * @var null
     */
    protected $filter = null;

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        return null;
    }

    /**
     * Set the filter.
     *
     * @param TableFilterInterface $filter
     * @return $this
     */
    public function setFilter(TableFilterInterface $filter)
    {
        $this->filter = $filter;

        return $this;
    }
}
