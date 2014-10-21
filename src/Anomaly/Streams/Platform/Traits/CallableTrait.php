<?php namespace Anomaly\Streams\Platform\Traits;

trait CallableTrait
{
    /**
     * An array of registered callbacks.
     *
     * @var array
     */
    protected $callbacks = [];

    /**
     * Register a callback.
     *
     * @param $method
     * @param $callable
     * @return $this
     */
    public function on($method, \Closure $callable = null)
    {
        if ($callable) {
            $this->callbacks[$method] = $callable;
        }

        return $this;
    }

    /**
     * Fire a callback or return a default value.
     *
     * @param       $method
     * @param array $arguments
     * @return mixed|null
     */
    public function fire($method, $arguments = [])
    {
        if (isset($this->callbacks[$method])) {
            return call_user_func_array($this->callbacks[$method], $arguments);
        }

        $method = camel_case('on_' . $method);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        return null;
    }

    /**
     * Get the callbacks array.
     *
     * @return array
     */
    public function getCallbacks()
    {
        return $this->callbacks;
    }

    /**
     * Set the callbacks array.
     *
     * @param $callbacks
     * @return $this
     */
    public function setCallbacks($callbacks)
    {
        $this->callbacks = $callbacks;

        return $this;
    }
}
