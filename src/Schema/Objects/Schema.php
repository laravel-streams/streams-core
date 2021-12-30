<?php

namespace Streams\Core\Schema\Objects;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema as BaseSchema;
use GoldSpecDigital\ObjectOrientedOAS\Utilities\Arr as GArr;
use Illuminate\Support\Arr;

class Schema extends BaseSchema
{

    /**
     * @var \Streams\Core\Schema\Objects\Schema[]|null
     */
    protected $defs;

    protected $data = [];

    public function set($path, $value)
    {
        Arr::set($this->data, $path, $value);
        return $this;
    }

    public function get($path)
    {
        return Arr::get($this->data, $path);
    }

    public function has($path)
    {
        return Arr::has($this->data, $path);
    }

    public function merge($path, $value)
    {

        Arr::set($this->data, $path, $value);
        return $this;
    }

    public function defs(Schema ...$defs): self
    {
        $instance = clone $this;

        $instance->defs = $defs;

        return $instance;
    }

    protected function generate(): array
    {
        $defs = [];
        foreach ($this->defs ?? [] as $def) {
            $defs[ $def->objectId ] = $def->toArray();
        }

        $generated = parent::generate();
        $data      = GArr::filter([
            '$defs' => $defs,
        ]);
        return array_merge($data, $generated);
    }

}
