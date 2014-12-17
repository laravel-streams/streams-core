<?php namespace Anomaly\Streams\Platform\Ui\Table;

class TableLoader
{

    /**
     * Load parameters onto the target object.
     *
     * @param $target
     * @param $parameters
     */
    public function load($target, $parameters)
    {
        foreach ($parameters as $parameter => $value) {
            $this->loadParameter($target, $parameter, $value);
        }
    }

    /**
     * Load a parameter onto the action.
     *
     * @param $target
     * @param $parameter
     * @param $value
     */
    protected function loadParameter($target, $parameter, $value)
    {
        $setter = camel_case('set_' . $parameter);

        if (method_exists($target, $setter)) {
            call_user_func_array([$target, $setter], compact('value'));
        }
    }
}
