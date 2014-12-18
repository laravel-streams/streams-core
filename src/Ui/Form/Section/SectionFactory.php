<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

/**
 * Class SectionFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Section
 */
class SectionFactory
{

    /**
     * Available section defaults.
     *
     * @var array
     */
    protected $sections = [
        'fields' => [
            'section' => 'Anomaly\Streams\Platform\Ui\Form\Section\Type\FieldsSection',
        ]
    ];

    /**
     * Make a section.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['section']) && class_exists($parameters['section'])) {
            return app()->make($parameters['section'], $parameters);
        }

        if ($section = array_get($this->sections, array_get($parameters, 'section'))) {
            $parameters = array_replace_recursive($section, array_except($parameters, 'section'));
        }

        return app()->make(
            array_get($parameters, 'section', 'Anomaly\Streams\Platform\Ui\Form\Section\Section'),
            $parameters
        );
    }
}
