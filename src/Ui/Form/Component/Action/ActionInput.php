<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ActionInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionInput
{

    /**
     * The action guesser.
     *
     * @var ActionGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Resolver
     */
    protected $resolver;

    /**
     * The action normalizer.
     *
     * @var ActionNormalizer
     */
    protected $normalizer;

    /**
     * Create an ActionInput instance.
     *
     * @param Resolver         $resolver
     * @param ActionGuesser    $guesser
     * @param ActionNormalizer $normalizer
     */
    function __construct(Resolver $resolver, ActionGuesser $guesser, ActionNormalizer $normalizer)
    {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder action input.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function read(FormBuilder $builder)
    {
        $builder->setActions($this->resolver->resolve($builder->getActions()));

        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
    }
}
