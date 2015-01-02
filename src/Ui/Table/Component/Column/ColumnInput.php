<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ColumnInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column
 */
class ColumnInput
{

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The column normalizer.
     *
     * @var ColumnNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ColumnInput instance.
     *
     * @param Resolver         $resolver
     * @param ColumnNormalizer $normalizer
     */
    public function __construct(Resolver $resolver, ColumnNormalizer $normalizer)
    {
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the builder's column input.
     *
     * @param TableBuilder $builder
     */
    public function read(TableBuilder $builder)
    {
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
    }

    /**
     * Resolve the input.
     *
     * @param TableBuilder $builder
     */
    protected function resolveInput(TableBuilder $builder)
    {
        $builder->setColumns($this->resolver->resolve($builder->getColumns()));
    }

    /**
     * Normalize the input.
     *
     * @param TableBuilder $builder
     */
    protected function normalizeInput(TableBuilder $builder)
    {
        $builder->setColumns($this->normalizer->normalize($builder->getColumns()));
    }
}
