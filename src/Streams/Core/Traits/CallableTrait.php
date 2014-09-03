<?php namespace Streams\Core\Traits;

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
     * Fire a callback.
     *
     * @return mixed|null
     */
    public function fire($method, $arguments = [])
    {
        if (isset($this->callbacks[$method])) {
            return call_user_func_array($this->callbacks[$method], $arguments);
        }

        $method = \Str::camel('on_' . $method);

        if (method_exists($this, $method)) {
            return call_user_func_array([$this, $method], $arguments);
        }

        return null;
    }
}
