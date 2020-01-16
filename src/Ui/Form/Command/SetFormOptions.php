<?php

namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

class SetFormOptions
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
     */
    public function handle()
    {
        evaluate(
            resolver($this->builder->getOptions(), ['builder' => $this->builder]),
            ['builder' => $this->builder]
        );

        foreach ($this->builder->getOptions() as $key => $value) {
            $this->builder->setFormOption($key, $value);
        }
    }
}
