<?php

namespace Streams\Core\Support;

use Illuminate\Support\Arr;

class Transformer
{

    /**
     * The array of transformers.
     *
     * @var array
     */
    protected $steps = [];

    public function integrate($target, $details)
    {
        foreach ($details as $type => $payload) {
            $this->{$type}($payload);
        }
    }

    /**
     * Transform an object.
     *
     * @param $object
     * @param array $parameters
     * @return mixed
     */
    public function transform($target, $name, array $payload = [])
    {
        $payload['target'] = $target;
        $prefix = $this->prefix($target);
        $transformer = $this->get($key = $prefix . '.' . $name);

        if (!$transformer) {
            return $target;
        }

        if (is_array($transformer)) {
            $workflow = new Workflow($transformer);
        }

        if (is_string($transformer)) {
            $workflow = new $transformer;
        }

        $workflow->setPrototypeAttribute('name', $key)
            //->passThrough($this)
            ->process($payload);

        return $payload['target'];
    }

    public function register($target, $transformer)
    {
        $this->transformers[$target] = $transformer;

        return $this;
    }

    public function has($target)
    {
        return Arr::has($this->transformers, $target);
    }

    public function get($target, $default = [])
    {
        return Arr::get($this->transformers, $target, $default);
    }

    protected function prefix($object)
    {
        if (is_string($object)) {
            return $object;
        }

        if (!is_object($object)) {
            return gettype($object);
        }

        return get_class($object);
    }
}
