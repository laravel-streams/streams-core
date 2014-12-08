<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

class TabFactory
{

    protected $tabs = [];

    public function make(array $parameters)
    {
        if (isset($parameters['tab']) and class_exists($parameters['tab'])) {

            return app()->make($parameters['tab'], $parameters);
        }

        if ($tab = array_get($this->tabs, array_get($parameters, 'tab'))) {

            $parameters = array_replace_recursive($tab, array_except($parameters, 'tab'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Tab\Tab', $parameters);
    }
}
 