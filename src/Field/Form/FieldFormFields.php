<?php namespace Anomaly\Streams\Platform\Field\Form;

use Anomaly\Streams\Platform\Field\Form\Command\GetConfigFields;
use Illuminate\Foundation\Bus\DispatchesJobs;

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

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @param FieldFormBuilder $builder
     */
    public function handle(FieldFormBuilder $builder)
    {
        $id        = $builder->getFormEntryId();
        $namespace = $builder->getFieldNamespace();

        $builder->setFields(
            [
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
                    'config'       => [
                        'slugify' => 'name',
                        'type'    => '_'
                    ],
                    'rules'        => [
                        'unique' => 'streams_fields,slug,' . $id . ',namespace,namespace,' . $namespace
                    ]
                ],
                'placeholder'  => [
                    'label'        => 'streams::field.placeholder.name',
                    'instructions' => 'streams::field.placeholder.instructions',
                    'type'         => 'anomaly.field_type.text'
                ],
                'instructions' => [
                    'label'        => 'streams::field.instructions.name',
                    'instructions' => 'streams::field.instructions.instructions',
                    'type'         => 'anomaly.field_type.textarea'
                ],
                'warning'      => [
                    'label'        => 'streams::field.warning.name',
                    'instructions' => 'streams::field.warning.instructions',
                    'type'         => 'anomaly.field_type.text'
                ]
            ]
        );

        if (($type = $builder->getFormEntry()->getType()) || ($type = $builder->getFieldType())) {
            $this->dispatch(new GetConfigFields($builder, $type));
        }
    }
}
