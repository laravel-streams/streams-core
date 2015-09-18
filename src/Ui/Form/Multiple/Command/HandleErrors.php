<?php

namespace Anomaly\Streams\Platform\Ui\Form\Multiple\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\MessageBag;

/**
 * Class HandleErrors.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Multiple\Command
 */
class HandleErrors implements SelfHandling
{
    /**
     * The multiple form builder.
     *
     * @var MultipleFormBuilder
     */
    protected $builder;

    /**
     * Create a new HandleErrors instance.
     *
     * @param MultipleFormBuilder $builder
     */
    public function __construct(MultipleFormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        /* @var FormBuilder $builder */
        foreach ($this->builder->getForms() as $builder) {
            if ($builder->hasFormErrors()) {

                // We can't save now!
                $this->builder->setSave(false);

                /*
                 * Merge errors from child forms into the
                 * multiple form builder's form instance.
                 */
                $this->mergeErrors($builder->getFormErrors());
            }
        }
    }

    /**
     * Merge the errors into the multiple form builder.
     *
     * @param MessageBag $errors
     */
    protected function mergeErrors(MessageBag $errors)
    {
        foreach ($errors->all() as $field => $message) {
            $this->builder->addFormError($field, $message);
        }
    }
}
