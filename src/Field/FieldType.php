<?php

namespace Streams\Core\Field;

use Streams\Core\Field\Value\Value;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Field\Factory\Generator;

class FieldType
{
    use HasMemory;
    use Prototype;
    use Macroable;

    protected $__attributes = [
        'name' => '',
        'description' => '',
        'rules' => [],
        'config' => [],
    ];

    /**
     * Modify the value for storage.
     *
     * @param string $value
     * @return string
     */
    public function modify($value)
    {
        return $value;
    }

    /**
     * Restore the value from storage.
     *
     * @param mixed $value
     * @return mixed
     */
    public function restore($value)
    {
        return $value;
    }

    public function expand($value)
    {
        return new Value($value);
    }

    public function generate()
    {
        return $this->generator()->create();
    }

    public function generator(): Generator
    {
        return new Generator($this);
    }

    /**
     * Return a field configuration value.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return $this->getPrototypeAttribute("config.{$key}", $default);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
