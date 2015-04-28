<?php namespace Anomaly\Streams\Platform\Assignment\Form;

use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

class AssignmentFormFields
{

    public function handle(AssignmentFormBuilder $builder)
    {
        $builder->setFields(
            [
                'field'        => [
                    'label'        => 'streams::assignment.field.label',
                    'instructions' => 'streams::assignment.field.instructions',
                    'type'         => 'anomaly.field_type.select',
                    'enabled'      => 'create',
                    'required'     => true,
                    'config'       => [
                        'options' => function (FieldRepositoryInterface $fields) use ($builder) {
                            return $fields
                                ->findByNamespace($builder->getStream()->getNamespace())
                                ->unassigned()
                                ->lists('name', 'id');
                        }
                    ]
                ],
                'required'     => [
                    'label'        => 'streams::assignment.required.label',
                    'instructions' => 'streams::assignment.required.instructions',
                    'type'         => 'anomaly.field_type.boolean',
                    'disabled'     => 'edit'
                ],
                'unique'       => [
                    'label'        => 'streams::assignment.unique.label',
                    'instructions' => 'streams::assignment.unique.instructions',
                    'type'         => 'anomaly.field_type.boolean',
                    'disabled'     => 'edit'
                ],
                'translatable' => [
                    'label'        => 'streams::assignment.translatable.label',
                    'instructions' => 'streams::assignment.translatable.instructions',
                    'type'         => 'anomaly.field_type.boolean',
                    'disabled'     => 'edit'
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
                ]
            ]
        );
    }
}
