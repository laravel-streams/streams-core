<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Support\Resolver;
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
     * @var Resolver
     */
    protected $resolver;

    /**
     * The header normalizer.
     *
     * @var HeaderNormalizer
     */
    protected $normalizer;

    /**
     * Create a new HeaderInput instance.
     *
     * @param Resolver         $resolver
     * @param HeaderNormalizer $normalizer
     * @param HeaderGuesser    $guesser
     */
    public function __construct(Resolver $resolver, HeaderNormalizer $normalizer, HeaderGuesser $guesser)
    {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
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
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
        $this->guessInput($builder);
    }

    /**
     * Resolve the header input.
     *
     * @param TableBuilder $builder
     */
    protected function resolveInput(TableBuilder $builder)
    {
        $builder->setColumns($this->resolver->resolve($builder->getColumns()));
    }

    /**
     * Normalize the header input.
     *
     * @param TableBuilder $builder
     */
    protected function normalizeInput(TableBuilder $builder)
    {
        $builder->setColumns($this->normalizer->normalize($builder->getColumns()));
    }

    /**
     * Guess the header input.
     *
     * @param TableBuilder $builder
     */
    protected function guessInput($builder)
    {
        $builder->setColumns($this->guesser->guess($builder->getColumns()));
    }
}
