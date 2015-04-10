<?php namespace Anomaly\Streams\Platform\Assignment\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class AssignmentFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Assignment\Form
 */
class AssignmentFormBuilder extends FormBuilder
{

    /**
     * The form fields.
     *
     * @var array
     */
    protected $fields = [
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
        'translatable' => [
            'label'        => 'streams::assignment.translatable.label',
            'instructions' => 'streams::assignment.translatable.instructions',
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
        ]
    ];

}
