<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

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
     * The view resolver.
     *
     * @var ViewResolver
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
     * @param ViewResolver   $resolver
     * @param ViewNormalizer $normalizer
     */
    public function __construct(ViewResolver $resolver, ViewNormalizer $normalizer)
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
        $this->resolver->resolve($builder);
        $this->normalizer->normalize($builder);
    }
}
