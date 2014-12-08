<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Laracasts\Commander\CommanderTrait;

class SectionFactory
{

    use CommanderTrait;

    public function make(array $parameters)
    {

        if (isset($parameters['section']) and class_exists($parameters['section'])) {

            return app()->make($parameters['section'], $parameters);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Section\Section', $parameters);
    }
}
 