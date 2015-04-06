<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

class SetFormOptions implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new SetFormOptions instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param Resolver  $resolver
     * @param Evaluator $evaluator
     */
    public function handle(Resolver $resolver, Evaluator $evaluator)
    {
        $arguments = ['builder' => $this->builder];

        $form = $this->builder->getForm();

        $options = $evaluator->evaluate($resolver->resolve($this->builder->getOptions(), $arguments), $arguments);

        foreach ($options as $key => $value) {
            $form->setOption($key, $value);
        }
    }
}
