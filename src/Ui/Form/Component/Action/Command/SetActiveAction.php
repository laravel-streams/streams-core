<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SetActiveAction.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
 */
class SetActiveAction
{
    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFormFiltersCommand instance.
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
