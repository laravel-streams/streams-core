<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

class TabFactory
{

    protected $tabs;

    function __construct(TabRepository $tabs)
    {
        $this->tabs = $tabs;
    }

    public function make(array $parameters)
    {
        if (isset($parameters['tab']) and class_exists($parameters['tab'])) {

            return app()->make($parameters['tab'], $parameters);
        }

        if ($tab = array_get($parameters, 'tab') and $tab = $this->tabs->find($tab)) {

            $tab = array_replace_recursive($tab, array_except($parameters, 'tab'));

            return app()->make($tab['tab'], $tab);
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Tab\Tab', $parameters);
    }
}
 