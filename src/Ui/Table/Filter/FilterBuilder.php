<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class FilterBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter
 */
class FilterBuilder
{

    use CommanderTrait;

    /**
     * The filter converter.
     *
     * @var FilterConverter
     */
    protected $converter;

    /**
     * The filter factory.
     *
     * @var FilterFactory
     */
    protected $factory;

    /**
     * Create a new FilterBuilder instance.
     *
     * @param FilterConverter $converter
     * @param FilterFactory   $factory
     */
    function __construct(FilterConverter $converter, FilterFactory $factory)
    {
        $this->converter = $converter;
        $this->factory   = $factory;
    }

    /**
     * Load filters onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($builder->getViews() as $key => $parameters) {

            $parameters = $this->converter->standardize($key, $parameters);

            $parameters['stream'] = $table->getStream();

            $filter = $this->factory->make($parameters);

            $filters->put($filter->getSlug(), $filter);
        }
    }
}
