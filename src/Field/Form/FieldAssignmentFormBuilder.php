<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormCollection;
use Anomaly\Streams\Platform\Ui\Form\Multiple\MultipleFormBuilder;

/**
 * Class FieldAssignmentFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldAssignmentFormBuilder extends MultipleFormBuilder
{

    /**
     * @param FieldFormBuilder $builder
     * @param FormCollection   $forms
     */
    public function onSavingField(FieldFormBuilder $builder, FormCollection $forms)
    {
        $field = $builder->getFormEntry();

        $field->namespace = $this->getFormOption('stream')->getNamespace();

        /* @var FormBuilder $form */
        $form = $forms->get('assignment');

        $assignment = $form->getFormEntry();

        $assignment->field_id = $field->getId();
    }

    /**
     * @param FieldFormBuilder $builder
     * @param FormCollection   $forms
     */
    public function onSavedField(FieldFormBuilder $builder, FormCollection $forms)
    {
        $field = $builder->getFormEntry();

        /* @var FormBuilder $form */
        $form = $forms->get('assignment');

        $assignment = $form->getFormEntry();

        $assignment->field_id  = $field->getId();
        $assignment->stream_id = $this->getFormOption('stream')->getId();
    }
}
