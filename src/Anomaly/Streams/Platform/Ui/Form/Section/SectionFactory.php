<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Laracasts\Commander\CommanderTrait;

class SectionFactory
{

    protected $sections = [];

    public function make(array $parameters)
    {
        if (isset($parameters['section']) and class_exists($parameters['section'])) {

            return app()->make($parameters['section'], $parameters);
        }

        if ($section = array_get($this->sections, array_get($parameters, 'section'))) {

            $parameters = array_replace_recursive($section, array_except($parameters, 'section'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Section\Section', $parameters);
    }
}
 