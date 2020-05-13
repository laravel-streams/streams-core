<?php

namespace Anomaly\Streams\Platform\Ui\Table\Event;

use Anomaly\Streams\Platform\Criteria\Contract\CriteriaInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TableIsQuerying
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TableIsQuerying
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * The table criteria.
     *
     * @var CriteriaInterface
     */
    protected $criteria;

    /**
     * Create a new TableIsQuerying instance.
     *
     * @param TableBuilder $builder
     * @param CriteriaInterface $criteria
     */
    public function __construct(TableBuilder $builder, CriteriaInterface $criteria)
    {
        $this->builder = $builder;
        $this->criteria = $criteria;
    }

    /**
     * Get the criteria.
     *
     * @return CriteriaInterface
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Get the table.
     *
     * @return TableBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
