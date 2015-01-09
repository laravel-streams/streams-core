<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

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

    /**
     * The filter reader.
     *
     * @var FilterInput
     */
    protected $input;

    /**
     * The filter factory.
     *
     * @var FilterFactory
     */
    protected $factory;

    /**
     * Create a new FilterBuilder instance.
     *
     * @param FilterInput   $input
     * @param FilterFactory $factory
     */
    public function __construct(FilterInput $input, FilterFactory $factory)
    {
        $this->input   = $input;
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

        $this->input->read($builder);

        foreach ($builder->getFilters() as $slug => $filter) {
            $filters->put($slug, $this->factory->make($filter));
        }
    }
}
