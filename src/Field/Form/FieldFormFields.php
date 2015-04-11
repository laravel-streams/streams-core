<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Field\Form\Command\GetConfigFields;
use Illuminate\Foundation\Bus\DispatchesCommands;

class FieldFormFields
{

    use DispatchesCommands;

    public function handle(FieldFormBuilder $builder)
    {
        $fields = [
            'type' => [
                'label'        => 'streams::field.type.name',
                'instructions' => 'streams::field.type.instructions',
                'type'         => 'anomaly.field_type.select',
                'required'     => true,
                'disabled'     => 'edit',
                'config'       => [
                    'options' => function (FieldTypeCollection $fieldTypes) {
                        return $fieldTypes->lists('name', 'namespace');
                    }
                ],
                'attributes'   => [
                    'onclick' => 'alert($(this).val());'
                ]
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
                'disabled'     => 'edit',
                'config'       => [
                    'slugify' => 'name'
                ]
            ]
        ];

        $config = [];//$this->dispatch(new GetConfigFields());

        $builder->setFields(array_merge($fields, array_values($config)));
    }
}
