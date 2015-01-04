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
     * @param ActionNormalizer $normalizer
     */
    function __construct(Resolver $resolver, ActionNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
        $this->resolver   = $resolver;
    }

    /**
     * Read builder action input.
     *
     * @param FormBuilder $builder
     * @return array
     */
    public function read(FormBuilder $builder)
    {
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
    }

    /**
     * Resolve the action input.
     *
     * @param FormBuilder $builder
     */
    protected function resolveInput(FormBuilder $builder)
    {
        $builder->setActions($this->resolver->resolve($builder->getActions()));
    }

    /**
     * Normalize the action input.
     *
     * @param FormBuilder $builder
     */
    protected function normalizeInput(FormBuilder $builder)
    {
        $form    = $builder->getForm();
        $options = $form->getOptions();
        $prefix  = $options->get('prefix');

        $builder->setActions($this->normalizer->normalize($builder->getActions(), $prefix));
    }
}
