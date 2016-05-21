<?php namespace Anomaly\Streams\Platform\Stream\Form;

use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class StreamFormFields
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Stream\Form
 */
class StreamFormFields implements SelfHandling
{

    /**
     * Handle the fields.
     *
     * @param StreamFormBuilder $builder
     */
    public function handle(StreamFormBuilder $builder)
    {
        $id        = $builder->getFormEntryId();
        $namespace = $builder->getNamespace();

        $builder->setFields(
            [
                'name'         => [
                    'label'        => 'streams::field.name.name',
                    'instructions' => 'streams::field.name.instructions',
                    'required'     => true,
                    'translatable' => true,
                    'type'         => 'anomaly.field_type.text',
                    'config'       => [
                        'max'       => 60,
                        'suggested' => 20
                    ]
                ],
                'slug'         => [
                    'label'        => 'streams::field.slug.name',
                    'instructions' => 'streams::field.slug.instructions',
                    'unique'       => true,
                    'required'     => true,
                    'type'         => 'anomaly.field_type.slug',
                    'config'       => [
                        'slugify' => 'name',
                        'type'    => '_',
                        'max'     => 60
                    ],
                    'rules'        => [
                        'unique' => 'streams_streams,slug,' . $id . ',id,namespace,' . $namespace
                    ]
                ],
                'description'  => [
                    'label'        => 'streams::field.description.name',
                    'instructions' => 'streams::field.description.instructions',
                    'translatable' => true,
                    'type'         => 'anomaly.field_type.textarea'
                ],
                'translatable' => [
                    'label'        => 'streams::field.translatable.name',
                    'instructions' => 'streams::field.translatable.instructions',
                    'translatable' => true,
                    'disabled'     => 'edit',
                    'type'         => 'anomaly.field_type.boolean'
                ],
                'trashable'    => [
                    'label'        => 'streams::field.trashable.name',
                    'instructions' => 'streams::field.trashable.instructions',
                    'translatable' => true,
                    'type'         => 'anomaly.field_type.boolean'
                ],
                'sortable'     => [
                    'label'        => 'streams::field.sortable.name',
                    'instructions' => 'streams::field.sortable.instructions',
                    'translatable' => true,
                    'type'         => 'anomaly.field_type.boolean'
                ]
            ]
        );
    }
}
