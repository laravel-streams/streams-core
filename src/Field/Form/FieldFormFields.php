<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
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
     * Handle the command.
     *
     * @param FieldFormBuilder $builder
     */
    public function handle(FieldFormBuilder $builder, FieldTypeCollection $types)
    {
        $fields = [
            'namespace' => [
                'readonly' => true,
                'disabled' => 'edit',
                'type'     => 'anomaly.field_type.text',
                'value'    => $builder->getStreamNamespace()
            ],
            'type'      => [
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
            'name'      => [
                'label'        => 'streams::field.name.name',
                'instructions' => 'streams::field.name.instructions',
                'type'         => 'anomaly.field_type.text',
                'required'     => true
            ],
            'slug'      => [
                'label'        => 'streams::field.slug.name',
                'instructions' => 'streams::field.slug.instructions',
                'type'         => 'anomaly.field_type.slug',
                'required'     => true,
                'disabled'     => 'edit',
                'config'       => [
                    'slugify' => 'name',
                    'type'    => '_'
                ]
            ]
        ];

        $config = [];

        if ($type = $builder->getFormEntry()->getType()) {
            $config = $this->dispatch(new GetConfigFields($type));

            $builder->setFormOption(
                'sections',
                [
                    [
                        'tabs' => [
                            'field'         => [
                                'title'  => 'streams::tab.field',
                                'fields' => array_keys($fields)
                            ],
                            'configuration' => [
                                'title'  => 'streams::tab.configuration',
                                'fields' => array_keys($config)
                            ]
                        ]
                    ]
                ]
            );
        }

        $builder->setFields(array_merge($fields, array_values($config)));
    }
}
