<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
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
class BAKFieldAssignmentFormFields
{

    use DispatchesCommands;

    /**
     * Handle the form fields.
     *
     * @param FieldAssignmentFormBuilder $builder
     */
    public function handle(FieldAssignmentFormBuilder $builder)
    {
        /* @var FieldInterface $field */
        $field = $builder->getFormEntry();

        /* @var AssignmentInterface $assignment */
        $assignment = $field->getAssignments()->first();

        /* @var FieldType $type */
        $type = $field->getType() ?: app($builder->getOption('field_type'));

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
            ]
        ];

        $config = $this->dispatch(new GetConfigFields($type));

        $builder->setFields(array_merge($fields, array_values($config)));
    }
}
