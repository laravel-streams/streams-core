<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class StandardizeInputCommand
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Command
 */
class StandardizeInputCommand
{

    /**
     * The form builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormBuilder
     */
    protected $builder;

    /**
     * Create a new StandardizeInputCommand instance.
     *
     * @param FormBuilder $builder
     */
    public function __construct(FormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Get the form builder.
     *
     * @return FormBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }
}
