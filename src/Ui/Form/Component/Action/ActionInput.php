<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

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
     * @var ActionResolver
     */
    protected $resolver;

    /**
     * The action defaults utility.
     *
     * @var ActionDefaults
     */
    protected $defaults;

    /**
     * The action predictor.
     *
     * @var ActionPredictor
     */
    protected $predictor;

    /**
     * The action normalizer.
     *
     * @var ActionNormalizer
     */
    protected $normalizer;

    /**
     * Create an ActionInput instance.
     *
     * @param ActionGuesser    $guesser
     * @param ActionResolver   $resolver
     * @param ActionDefaults   $defaults
     * @param ActionPredictor  $predictor
     * @param ActionNormalizer $normalizer
     */
    function __construct(
        ActionGuesser $guesser,
        ActionResolver $resolver,
        ActionDefaults $defaults,
        ActionPredictor $predictor,
        ActionNormalizer $normalizer
    ) {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->defaults   = $defaults;
        $this->predictor  = $predictor;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder action input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $this->resolver->resolve($builder);
        $this->defaults->defaults($builder);
        $this->predictor->predict($builder);
        $this->normalizer->normalize($builder);
        $this->guesser->guess($builder);
    }
}
