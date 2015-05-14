<?php namespace Anomaly\Streams\Platform\Field\Form;

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
    public function handle(FieldFormBuilder $builder)
    {
        $builder->setSections(
            [
                'field'         => [
                    'fields' => function (FieldFormBuilder $builder) {
                        return array_map(
                            function ($field) {
                                return $field['field'];
                            },
                            array_filter(
                                $builder->getFields(),
                                function ($field) {
                                    return starts_with($field['field'], 'config.') ? false : true;
                                }
                            )
                        );
                    }
                ],
                'configuration' => [
                    'fields' => function (FieldFormBuilder $builder) {
                        return array_map(
                            function ($field) {
                                return $field['field'];
                            },
                            array_filter(
                                $builder->getFields(),
                                function ($field) {
                                    return !starts_with($field['field'], 'config.') ? false : true;
                                }
                            )
                        );
                    }
                ]
            ]
        );
    }
}
