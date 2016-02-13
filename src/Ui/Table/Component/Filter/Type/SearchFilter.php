<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\SearchFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query\SearchFilterQuery;
use Closure;

/**
 * Class SearchFilter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type
 */
class SearchFilter extends Filter implements SearchFilterInterface
{

    /**
     * The columns to search.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * The filter query.
     *
     * @var string|Closure
     */
    protected $query = SearchFilterQuery::class;

    /**
     * Get the input HTML.
     *
     * @return string
     */
    public function getInput()
    {
        return app('form')->input(
            'text',
            $this->getInputName(),
            $this->getValue(),
            [
                'class'       => 'form-control',
                'placeholder' => trans('streams::message.search')
            ]
        );
    }

    /**
     * Get the columns.
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Set the columns.
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;

        return $this;
    }
}
