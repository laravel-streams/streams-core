<?php

namespace Streams\Core\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;

class Workflow
{

    use Macroable;
    use FiresCallbacks;

    protected array $steps = [];

    protected ?string $name = null;

    protected ?\Closure $callback = null;

    protected $object = null;

    public function __construct(array $steps = [])
    {
        $this->steps = array_merge($this->steps, $steps);
    }

    public function process(array $payload = []): void
    {
        foreach ($this->steps as $name => $step) {

            $this->triggerCallback('before_' . $name, $payload);

            $this->do($step, $payload);

            $this->triggerCallback('after_' . $name, $payload);
        }
    }

    /**
     * Default callbacks through the provided object.
     *
     * @todo this may need removed
     * @param mixed $object
     */
    public function passThrough($object)
    {
        $this->object = $object;

        $this->callback = function ($callback, $payload) use ($object) {
            $object->fire(implode('_', $callback), $payload);
        };

        return $this;
    }

    protected function triggerCallback(string $name, array $payload)
    {
        $callback = array_filter([
            'workflow' => $this->name ?: $this->name($this),
            'name' => $name,
        ]);

        $bundle = compact('payload', 'callback');

        $this->callback ? App::call($this->callback, $bundle) : null;

        $method = Str::camel(implode('_', ['on'] + $callback));

        if ($this->object && method_exists($this->object, $method)) {
            App::call([$this->object, $method], $bundle);
        }

        $this->fire($name, $payload);
    }

    public function add(string $name, $step = null, int $position = null)
    {
        if (!$step && is_string($step)) {

            $step = $name;

            $name = $this->name($step);
        }

        if ($position === null) {
            $position = count($this->steps);
        }

        $this->steps = array_slice($this->steps, 0, $position, true) +
            [$name => $step] +
            array_slice($this->steps, $position, count($this->steps) - 1, true);

        return $this;
    }

    public function first(string $name, $step = null)
    {
        return $this->add($name, $step, 0);
    }

    public function before(string $target, string $name, $step = null)
    {
        return $this->add($name, $step, array_search($target, array_keys($this->steps)));
    }

    public function after(string $target, string $name, $step = null)
    {
        return $this->add($name, $step, array_search($target, array_keys($this->steps)) + 1);
    }

    public function getSteps(): array
    {
        return $this->steps;
    }

    public function setSteps(array $steps): Workflow
    {
        $this->steps = $steps;

        return $this;
    }

    // protected function named($steps): array
    // {
    //     $named = [];

    //     array_walk($steps, function ($step, $name) use (&$named) {

    //         if (is_string($name)) {

    //             $named[$name] = $step;

    //             return;
    //         }

    //         // if (is_string($step)) {

    //         //     $named[$this->name($step)] = $step;

    //         //     return true;
    //         // }

    //         // if (is_object($step)) {

    //         //     $named[$this->name($step)] = $step;

    //         //     return true;
    //         // }

    //         $named[$name] = $step;
    //     });

    //     return $named;
    // }

    protected function name($step): string
    {
        if ($step == $this) {
            return '';
        }

        if ($step instanceof \Closure) {
            return '';
        }

        if (is_object($step)) {
            $step = get_class($step);
        }

        $step = explode('\\', $step);

        $step = end($step);

        return Str::snake($step);
    }

    protected function do($step, array $payload = [])
    {
        if (is_array($step)) {
            return App::call($step, $payload);
        }

        return App::call($step, $payload, 'handle');
    }
}
