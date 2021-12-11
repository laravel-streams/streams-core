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

    public array $steps = [];

    protected ?\Closure $callback = null;

    public function process(array $payload = []): void
    {
        foreach ($this->steps as $name => $step) {

            $this->triggerCallback('before_' . $name, $payload);

            $this->do($step, $payload);

            $this->triggerCallback('after_' . $name, $payload);
        }
    }

    public function passThrough($object): Workflow
    {
        $this->callback = function ($name, $payload) use ($object) {
            $object->fire($name, $payload);
        };

        return $this;
    }

    public function addStep(string $name, $step, int $position = null)
    {
        if ($position === null) {
            $position = count($this->steps);
        }

        $this->steps = array_slice($this->steps, 0, $position, true) +
            [$name => $step] +
            array_slice($this->steps, $position, count($this->steps), true);

        return $this;
    }

    public function doFirst(string $name, $step)
    {
        return $this->addStep($name, $step, 0);
    }

    public function doBefore(string $target, string $name, $step)
    {
        return $this->addStep($name, $step, array_search($target, array_keys($this->steps)));
    }

    public function doAfter(string $target, string $name, $step)
    {
        return $this->addStep($name, $step, array_search($target, array_keys($this->steps)) + 1);
    }

    protected function triggerCallback(string $name, array $payload)
    {
        $bundle = compact('name', 'payload');

        $this->callback ? App::call($this->callback, $bundle) : null;

        $this->fire($name, $payload);
    }

    protected function do($step, array $payload = [])
    {
        if (is_array($step)) {
            return App::call($step, $payload);
        }

        return App::call($step, $payload, 'handle');
    }
}
