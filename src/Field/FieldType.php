<?php

namespace Streams\Core\Field;

use Streams\Core\Field\Value\Value;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;

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

    public function cast($value)
    {
        return $value;
    }

    public function modify($value)
    {
        return $value;
    }
    
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
        return $this->generator()->text();
    }

    public function generator()
    {
        // @todo app(this->config('generator))
        return $this->once(__METHOD__, fn () => \Faker\Factory::create());
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
