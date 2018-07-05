<?php namespace Anomaly\Streams\Platform\Assignment\Form;

use Illuminate\Contracts\Config\Repository;

/**
 * Class AssignmentFormSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssignmentFormSections
{

    /**
     * Handle the form sections.
     *
     * @param AssignmentFormBuilder $builder
     */
    public function handle(AssignmentFormBuilder $builder, Repository $config)
    {
        $builder->setSections([
            'general' => [
                'tabs' => [
                    'assignment'    => [
                        'title'  => 'streams::form.tab.display',
                        'fields' => [
                            'label',
                            'placeholder',
                            'instructions',
                            'warning',
                        ],
                    ],
                    'options'       => [
                        'title'  => 'streams::form.tab.options',
                        'fields' => [
                            'required',
                            'unique',
                            'searchable',
                            'translatable',
                        ],
                    ],
                    'configuration' => [
                        'title'  => 'streams::form.tab.config',
                        'fields' => function (AssignmentFormBuilder $builder) {
                            return array_map(
                                function ($key) {
                                    return "config__{$key}";
                                },
                                array_filter(
                                    array_keys($builder->getFieldType()->getConfig()),
                                    function ($key) {
                                        return $key != 'handler';
                                    }
                                )
                            );
                        },
                    ],
                ],
            ],
        ]);
    }
}
