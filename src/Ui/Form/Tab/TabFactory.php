<?php namespace Anomaly\Streams\Platform\Ui\Form\Tab;

/**
 * Class TabFactory
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Tab
 */
class TabFactory
{

    /**
     * Available tab defaults.
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * Make a tab.
     *
     * @param  array $parameters
     * @return mixed
     */
    public function make(array $parameters)
    {
        if (isset($parameters['tab']) && class_exists($parameters['tab'])) {
            return app()->make($parameters['tab'], $parameters);
        }

        if ($tab = array_get($this->tabs, array_get($parameters, 'tab'))) {
            $parameters = array_replace_recursive($tab, array_except($parameters, 'tab'));
        }

        return app()->make('Anomaly\Streams\Platform\Ui\Form\Tab\Tab', $parameters);
    }
}
