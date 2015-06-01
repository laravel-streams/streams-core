<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderInput
{

    /**
     * @var HeaderGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var HeaderResolver
     */
    protected $resolver;

    /**
     * The header defaults;
     *
     * @var HeaderDefaults
     */
    protected $defaults;

    /**
     * The header normalizer.
     *
     * @var HeaderNormalizer
     */
    protected $normalizer;

    /**
     * Create a new HeaderInput instance.
     *
     * @param HeaderGuesser    $guesser
     * @param HeaderResolver   $resolver
     * @param HeaderDefaults   $defaults
     * @param HeaderNormalizer $normalizer
     */
    public function __construct(
        HeaderGuesser $guesser,
        HeaderResolver $resolver,
        HeaderDefaults $defaults,
        HeaderNormalizer $normalizer
    ) {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->defaults   = $defaults;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder header input.
     *
     * @param TableBuilder $builder
     * @return array
     */
    public function read(TableBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->defaults->defaults($builder);
        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
    }
}
