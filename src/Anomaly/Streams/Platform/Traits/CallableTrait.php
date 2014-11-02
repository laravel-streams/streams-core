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
     * @param $trigger
     * @param $callable
     * @return $this
     */
    public function on($trigger, \Closure $callable = null)
    {
        if ($callable) {

            if (!isset($this->callbacks[$trigger])) {

                $this->callbacks[$trigger] = [];
            }

            $this->callbacks[$trigger][] = $callable;
        }

        return $this;
    }

    /**
     * Fire a callback or return a default value.
     *
     * @param       $trigger
     * @param array $arguments
     * @return mixed|null
     */
    public function fire($trigger, $arguments = [])
    {
        if (isset($this->callbacks[$trigger]) and $callbacks = $this->callbacks[$trigger]) {

            foreach ($callbacks as $callback) {

                app()->call($callback, $arguments);
            }
        }

        $trigger = camel_case('on_' . $trigger);

        if (method_exists($this, $trigger)) {

            try {

                return app()->call(get_class($this) . '@' . $trigger, $arguments);
            } catch (\Exception $e) {

                return call_user_func_array([$this, $trigger], $arguments);
            }
        }
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
