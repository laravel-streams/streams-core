<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class FieldFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormBuilder extends FormBuilder
{

    protected $fields = [
        'name' => [
            'label'        => 'streams::field.name.name',
            'instructions' => 'streams::field.name.instructions',
            'type'         => 'anomaly.field_type.text',
            'required'     => true
        ]
    ];

}
