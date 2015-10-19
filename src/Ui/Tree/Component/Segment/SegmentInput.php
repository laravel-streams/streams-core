<?php namespace Anomaly\Streams\Platform\Ui\Tree\Component\Segment;

use Anomaly\Streams\Platform\Ui\Tree\TreeBuilder;

/**
 * Class SegmentInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Segment
 */
class SegmentInput
{

    /**
     * The resolver utility.
     *
     * @var SegmentResolver
     */
    protected $resolver;

    /**
     * The segment translator.
     *
     * @var SegmentTranslator
     */
    protected $translator;

    /**
     * The segment normalizer.
     *
     * @var SegmentNormalizer
     */
    protected $normalizer;

    /**
     * Create a new SegmentInput instance.
     *
     * @param SegmentResolver   $resolver
     * @param SegmentTranslator $translator
     * @param SegmentNormalizer $normalizer
     */
    public function __construct(SegmentResolver $resolver, SegmentTranslator $translator, SegmentNormalizer $normalizer)
    {
        $this->resolver   = $resolver;
        $this->translator = $translator;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the builder's segment input.
     *
     * @param TreeBuilder $builder
     */
    public function read(TreeBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->normalizer->normalize($builder);
        $this->translator->translate($builder);
    }
}
