<?php namespace Anomaly\Streams\Platform\Stream\Form;

use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class StreamFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Form
 */
class StreamFormBuilder extends FormBuilder
{

    /**
     * The form model.
     *
     * @var StreamModel
     */
    protected $model = StreamModel::class;

    /**
     * The form fields.
     *
     * @var array
     */
    protected $fields = [
        'name'        => [
            'required'     => true,
            'translatable' => true,
            'type'         => 'anomaly.field_type.text'
        ],
        'slug'        => [
            'unique'   => true,
            'required' => true,
            'disabled' => 'edit',
            'type'     => 'anomaly.field_type.slug',
            'config'   => [
                'slugify' => 'name'
            ]
        ],
        'description' => [
            'translatable' => true,
            'type'         => 'anomaly.field_type.textarea'
        ],
    ];

}
