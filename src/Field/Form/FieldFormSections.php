<?php namespace Anomaly\Streams\Platform\Field\Form;

use Illuminate\Contracts\Config\Repository;

/**
 * Class FieldFormSections
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Field\Form
 */
class FieldFormSections
{

    /**
     * Handle the form sections.
     *
     * @param FieldFormBuilder $builder
     */
    public function handle(FieldFormBuilder $builder, Repository $config)
    {
        $builder->setSections(
            [
                'field' => [
                    'fields' => function (FieldFormBuilder $builder) {
                        return array_map(
                            function ($field) {
                                return $field['field'];
                            },
                            array_filter(
                                $builder->getFields(),
                                function ($field) {

                                    // No config fields.
                                    if (starts_with($field['field'], 'config.')) {
                                        return false;
                                    }

                                    // Only default locale fields.
                                    if (isset($field['locale']) && $field['locale'] !== config('app.fallback_locale')) {
                                        return false;
                                    }

                                    return true;
                                }
                            )
                        );
                    }
                ]
            ]
        );

        if (($type = $builder->getFormEntry()->getType()) || ($type = $builder->getFieldType())) {
            if ($sections = $config->get($type->getNamespace('config/sections'))) {
                foreach ($sections as $slug => $section) {
                    $builder->addSection($slug, $section);
                }
            } else {
                $builder->addSection(
                    'configuration',
                    [
                        'fields' => function (FieldFormBuilder $builder) {
                            return array_map(
                                function ($field) {
                                    return $field['field'];
                                },
                                array_filter(
                                    $builder->getFields(),
                                    function ($field) {

                                        // Only config fields.
                                        if (!starts_with($field['field'], 'config.')) {
                                            return false;
                                        }

                                        // Only default locale fields.
                                        if (isset($field['locale']) && $field['locale'] !== config(
                                                'app.fallback_locale'
                                            )
                                        ) {
                                            return false;
                                        }

                                        return true;
                                    }
                                )
                            );
                        }
                    ]
                );
            }
        }
    }
}
