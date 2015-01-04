<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\Component\Field\Guesser\FieldsGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldInput
{

    /**
     * The resolver utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Resolver
     */
    protected $resolver;

    /**
     * The field normalizer.
     *
     * @var FieldNormalizer
     */
    protected $normalizer;

    /**
     * The fields guesser.
     *
     * @var FieldsGuesser
     */
    protected $guesser;

    /**
     * Create a new FieldInput instance.
     *
     * @param Resolver        $resolver
     * @param FieldNormalizer $normalizer
     * @param FieldsGuesser   $guesser
     */
    function __construct(Resolver $resolver, FieldNormalizer $normalizer, FieldsGuesser $guesser)
    {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $this->resolveInput($builder);
        $this->normalizeInput($builder);

        $this->guessFields($builder);
        $this->normalizeInput($builder); // Again!
    }

    /**
     * Resolve the action input.
     *
     * @param FormBuilder $builder
     */
    protected function resolveInput(FormBuilder $builder)
    {
        $builder->setFields($this->resolver->resolve($builder->getFields()));
    }

    /**
     * Guess * fields replacer.
     *
     * @param FormBuilder $builder
     */
    protected function guessFields(FormBuilder $builder)
    {
        $form   = $builder->getForm();
        $stream = $form->getStream();

        $builder->setFields($this->guesser->guess($stream, $builder->getFields()));
    }

    /**
     * Normalize the action input.
     *
     * @param FormBuilder $builder
     */
    protected function normalizeInput(FormBuilder $builder)
    {
        $builder->setFields($this->normalizer->normalize($builder->getFields()));
    }
}
