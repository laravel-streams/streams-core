<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

/**
 * Class ActionLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionLoader
{

    /**
     * Load parameters onto the action.
     *
     * @param $action
     * @param $parameters
     */
    public function load($action, $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            $this->loadParameter($action, $parameter, $value);
        }
    }

    /**
     * Load a parameter onto the action.
     *
     * @param $action
     * @param $parameter
     * @param $value
     */
    protected function loadParameter($action, $parameter, $value)
    {
        $setter = camel_case('set_' . $parameter);

        if (method_exists($action, $setter)) {
            call_user_func_array([$action, $setter], compact('value'));
        }
    }
}
