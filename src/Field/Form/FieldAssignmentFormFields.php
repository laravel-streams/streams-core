<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Field\Form\Command\GetConfigFields;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class FieldAssignmentFormFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldAssignmentFormFields
{

    use DispatchesCommands;

    /**
     * Handle the form fields.
     *
     * @param FieldAssignmentFormBuilder $builder
     */
    public function handle(FieldAssignmentFormBuilder $builder)
    {
        $entry = $builder->getFormEntry();

        /* @var FieldType $type */
        $type = $entry->getType() ?: app($builder->getOption('field_type'));

        $fields = [
            'type'         => [
                'label'        => 'streams::field.type.name',
                'instructions' => 'streams::field.type.instructions',
                'type'         => 'anomaly.field_type.select',
                'value'        => $type->getNamespace(),
                'required'     => true,
                'disabled'     => $builder->getFormMode() == 'edit',
                'config'       => [
                    'options' => function (FieldTypeCollection $fieldTypes) {
                        return $fieldTypes->lists('name', 'namespace');
                    }
                ],
                'attributes'   => [
                    'onclick' => 'alert($(this).val());'
                ]
            ],
            'name'         => [
                'label'        => 'streams::field.name.name',
                'instructions' => 'streams::field.name.instructions',
                'type'         => 'anomaly.field_type.text',
                'required'     => true
            ],
            'slug'         => [
                'label'        => 'streams::field.slug.name',
                'instructions' => 'streams::field.slug.instructions',
                'type'         => 'anomaly.field_type.slug',
                'required'     => true,
                'disabled'     => $builder->getFormMode() == 'edit',
                'config'       => [
                    'slugify' => 'name'
                ]
            ],
            'required'     => [
                'label'        => 'streams::assignment.required.label',
                'instructions' => 'streams::assignment.required.instructions',
                'type'         => 'anomaly.field_type.boolean'
            ],
            'unique'       => [
                'label'        => 'streams::assignment.unique.label',
                'instructions' => 'streams::assignment.unique.instructions',
                'type'         => 'anomaly.field_type.boolean'
            ],
            'label'        => [
                'label'        => 'streams::assignment.label.name',
                'instructions' => 'streams::assignment.label.instructions',
                'type'         => 'anomaly.field_type.text'
            ],
            'instructions' => [
                'label'        => 'streams::assignment.instructions.name',
                'instructions' => 'streams::assignment.instructions.instructions',
                'type'         => 'anomaly.field_type.textarea'
            ],
        ];

        $config = $this->dispatch(new GetConfigFields($type));

        $builder->setFields(array_merge($fields, array_values($config)));
    }
}
