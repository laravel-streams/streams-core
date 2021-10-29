<?php

namespace Streams\Core\Field;

use Streams\Core\Field\Value\Value;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Streams\Core\Field\Factory\Generator;

/**
 * @typescript
 * @property string $name
 * @property string $description
 * @property mixed $rules
 * @property array<string,mixed> $config
 */
class FieldType
{
    use HasMemory;
    use Prototype;
    use Macroable;

    protected $__attributes = [
        'name' => '',
        'description' => '',
        'rules' => [],
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
