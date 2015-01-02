<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter
 */
class FilterInput
{

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The filter normalizer.
     *
     * @var FilterNormalizer
     */
    protected $normalizer;

    /**
     * Create a new FilterInput instance.
     *
     * @param Resolver         $resolver
     * @param FilterNormalizer $normalizer
     */
    public function __construct(Resolver $resolver, FilterNormalizer $normalizer)
    {
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the builder's filter input.
     *
     * @param TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
    }

    /**
     * Resolve filter input.
     *
     * @param TableBuilder $builder
     */
    protected function resolveInput(TableBuilder $builder)
    {
        $builder->setFilters($this->resolver->resolve($builder->getFilters()));
    }

    /**
     * Normalize filter input.
     *
     * @param TableBuilder $builder
     */
    protected function normalizeInput(TableBuilder $builder)
    {
        $table  = $builder->getTable();
        $stream = $table->getStream();

        $builder->setFilters($this->normalizer->normalize($builder->getFilters(), $stream));
    }
}
