<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableGuesser;
use Anomaly\Streams\Platform\Ui\Table\TableNormalizer;

/**
 * Class FilterInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FilterInput
{

    /**
     * The filter lookup.
     *
     * @var FilterLookup
     */
    protected $lookup;

    /**
     * Create a new FilterInput instance.
     *
     * @param FilterLookup     $lookup
     */
    public function __construct(
        FilterLookup $lookup
    ) {
        $this->lookup     = $lookup;
    }

    /**
     * Read the builder's filter input.
     *
     * @param  TableBuilder $builder
     */
    public function read(TableBuilder $builder)
    {
        $filters = $builder->getFilters();
        $stream = $builder->getTableStream();

        /**
         * Resolve & Evaluate
         */
        $filters = resolver($filters, compact('builder'));

        $filters = $filters ?: $builder->getFilters();

        $filters = evaluate($filters, compact('builder'));

        $builder->setFilters($filters);

        // ---------------------------------
        $filters = $builder->getFilters();

        $filters = TableNormalizer::filters($filters, $stream);
        $filters = TableNormalizer::attributes($filters);

        $builder->setFilters($filters);
        // ---------------------------------

        $this->lookup->merge($builder);

        TableGuesser::filters($builder);
    }
}
