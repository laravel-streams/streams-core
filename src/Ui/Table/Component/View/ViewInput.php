<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ViewInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewInput
{

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The view normalizer.
     *
     * @var ViewNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ViewInput instance.
     *
     * @param Resolver       $resolver
     * @param ViewNormalizer $normalizer
     */
    public function __construct(Resolver $resolver, ViewNormalizer $normalizer)
    {
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder view input.
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
     * Resolve the view input.
     *
     * @param TableBuilder $builder
     */
    protected function resolveInput(TableBuilder $builder)
    {
        $builder->setViews($this->resolver->resolve($builder->getViews()));
    }

    /**
     * Normalize the view input.
     *
     * @param TableBuilder $builder
     */
    protected function normalizeInput(TableBuilder $builder)
    {
        $builder->setViews($this->normalizer->normalize($builder->getViews()));
    }
}
