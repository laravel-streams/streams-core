<?php namespace Anomaly\Streams\Platform\Ui\Form\Event;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FormWasPosted
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Event
 */
class FormWasPosted
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new FormWasValidated instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Ge the form.
     *
     * @return FormBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
