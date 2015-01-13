<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Button\ButtonNormalizer;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonInput
{

    /**
     * The button guesser.
     *
     * @var ButtonGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The button normalizer.
     *
     * @var ButtonNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ButtonInput instance.
     *
     * @param Resolver         $resolver
     * @param ButtonGuesser    $guesser
     * @param ButtonNormalizer $normalizer
     */
    public function __construct(Resolver $resolver, ButtonGuesser $guesser, ButtonNormalizer $normalizer)
    {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder button input.
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
     * Resolve the button input.
     *
     * @param TableBuilder $builder
     */
    protected function resolveInput(TableBuilder $builder)
    {
        $builder->setButtons($this->resolver->resolve($builder->getButtons()));
    }

    /**
     * Normalize the button input.
     *
     * @param TableBuilder $builder
     */
    protected function normalizeInput(TableBuilder $builder)
    {
        $builder->setButtons($this->normalizer->normalize($builder->getButtons()));
    }

    /**
     * Guess the button input.
     *
     * @param TableBuilder $builder
     */
    protected function guessInput(TableBuilder $builder)
    {
        $builder->setButtons($this->guesser->guess($builder->getButtons()));
    }
}
