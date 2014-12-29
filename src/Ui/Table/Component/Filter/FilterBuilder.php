<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class FilterBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterBuilder
{

    use CommanderTrait;

    /**
     * The filter reader.
     *
     * @var FilterReader
     */
    protected $reader;

    /**
     * The filter factory.
     *
     * @var FilterFactory
     */
    protected $factory;

    /**
     * Create a new FilterBuilder instance.
     *
     * @param FilterReader  $reader
     * @param FilterFactory $factory
     */
    public function __construct(FilterReader $reader, FilterFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Build the filters.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($builder->getFilters() as $slug => $filter) {

            $filter = $this->reader->standardize($slug, $filter);

            $filter['stream'] = $table->getStream();

            $filter = $this->factory->make($filter);

            $filters->put($filter->getSlug(), $filter);
        }
    }
}
