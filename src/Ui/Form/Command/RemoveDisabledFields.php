<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class RemoveDisabledFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class RemoveDisabledFields implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var FormBuilder
     */
    protected $builder;

    /**
     * Create a new RemoveDisabledFields instance.
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
        $form = $this->builder->getForm();

        /* @var FieldType $field */
        foreach ($form->getFields() as $field) {
            if ($field->isDisabled()) {
                $form->removeField($field->getField());
            }
        }
    }
}
