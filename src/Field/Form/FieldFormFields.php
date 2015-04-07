<?php namespace Anomaly\Streams\Platform\Field\Form;

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

    /**
     * Handle the form fields.
     *
     * @param FieldFormBuilder $builder
     */
    public function handle(FieldFormBuilder $builder)
    {
        $builder->setFields(
            [
                'type' => [
                    'label'        => 'streams::field.type.name',
                    'instructions' => 'streams::field.type.instructions',
                    'type'         => 'anomaly.field_type.text',
                    'required'     => true,
                    'disabled'     => true
                ],
                'name' => [
                    'label'        => 'streams::field.name.name',
                    'instructions' => 'streams::field.name.instructions',
                    'type'         => 'anomaly.field_type.text',
                    'required'     => true
                ],
                'slug' => [
                    'label'        => 'streams::field.slug.name',
                    'instructions' => 'streams::field.slug.instructions',
                    'type'         => 'anomaly.field_type.slug',
                    'required'     => true,
                    'disabled'     => true,
                    'config'       => [
                        'slugify' => 'name'
                    ]
                ]
            ]
        );
    }
}
