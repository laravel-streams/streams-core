<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Field\Form\Command\GetConfigFields;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class FieldFormFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormFields
{

    use DispatchesCommands;

    /**
     * Handle the form fields.
     *
     * @param FieldFormBuilder $builder
     */
    public function handle(FieldFormBuilder $builder)
    {
        $entry = $builder->getFormEntry();

        $type = $entry->getType() ?: app($builder->getOption('field_type'));

        $fields = [
            'type'         => [
                'label'        => 'streams::field.type.name',
                'instructions' => 'streams::field.type.instructions',
                'type'         => 'anomaly.field_type.text',
                'required'     => true,
                'disabled'     => true
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
                'disabled'     => true,
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
