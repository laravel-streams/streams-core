<?php

namespace Anomaly\Streams\Platform\Workflow;

use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Illuminate\Support\Facades\App;

/**
 * Class Workflow
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Workflow
{
    use FiresCallbacks;

    /**
     * The workflow steps.
     */
    protected array $steps;

    /**
     * Create a new Workflow instance.
     *
     * @param array $steps
     */
    public function __construct(array $steps = [])
    {
        $this->steps = $this->named($steps);
    }

    /**
     * Process the workflow.
     *
     * @param array $payload
     * @return mixed
     */
    public function process(array $payload = [])
    {
        $this->fire('processing', $payload);

        foreach ($this->steps as $name => $step) {

            $this->fire('before_' . $name, $payload);

            $this->do($step, $payload);

            $this->fire('after_' . $name, $payload);
        }

        $this->fire('processed', $payload);
    }

    /**
     * Add a step to the workflow.
     *
     * @param stirng $name
     * @param string|\Closure $step
     * @param string $position
     */
    public function add($name, $step = null, string $before = null)
    {
        if (!$step && is_string($step)) {
            
            $step = $name;

            $name = $this->name($step);
        }

        $position = count($this->steps) + 1;

        if (is_string($before)) {
            $position = array_search($before, $this->steps) - 1;
        }

        $front = array_slice($this->steps, 0, $position, true);
        $back  = array_slice($this->steps, $position, count($this->steps) - $position, true);

        $this->steps = $front + [$name => $step] + $back;

        return $this;
    }

    /**
     * Name the steps.
     *
     * @param array $steps
     */
    private function named($steps)
    {
        $named = [];

        array_walk($steps, function($step, $name) use (&$named) {
            
            if (is_string($name)) {

                $named[$name] = $step;

                return;
            }

            if (is_string($step)) {
                
                $named[$this->name($step)] = $step;

                return true;
            }

            if (is_object($step)) {
                
                $named[$this->name($step)] = $step;

                return true;
            }

            $named[$name] = $step;
        });

        return $named;
    }

    /**
     * Return the step name.
     *
     * @param mixed $step
     */
    public function name($step)
    {
        if (is_object($step)) {
            $step = get_class($step);
        }

        $step = explode('\\', $step);

        $step = end($step);

        return snake_case($step);
    }

    /**
     * Do the step with the payload.
     *
     * @param mixed $step
     * @param array $payload
     */
    private function do($step, array $payload = [])
    {
        if (is_string($step)) {
            return App::call($step, $payload, 'handle');
        }

        if (is_callable($step)) {
            return App::call($step, $payload);
        }
    }
}
