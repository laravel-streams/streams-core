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
     * @var FilterResolver
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
     * @param FilterResolver   $resolver
     * @param FilterNormalizer $normalizer
     */
    public function __construct(FilterResolver $resolver, FilterNormalizer $normalizer)
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
        $this->resolver->resolve($builder);
        $this->normalizer->normalize($builder);
    }
}
