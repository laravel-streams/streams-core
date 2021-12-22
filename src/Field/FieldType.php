<?php

namespace Streams\Core\Field;

use Illuminate\Support\Arr;
use Streams\Core\Field\Value\Value;
use Streams\Core\Field\Factory\Factory;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

/**
 * @typescript
 * @property string $name
 * @property string $description
 * @property mixed $rules
 * @property Field $field
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

    public function default($value)
    {
        return $value;
    }

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
        $name = $this->field->config('expanded', $this->getValueName());

        return new $name($this, $value);
    }

    public function getValueName()
    {
        return Value::class;
    }

    public function schema(): FieldSchema
    {
        $schema = $this->field->config('schema', $this->getSchemaName());

        return new $schema($this);
    }

    protected function getSchemaName()
    {
        return FieldSchema::class;
    }

    public function rules()
    {
        return Arr::get($this->field->stream->rules, $this->field->handle, []);
    }

    public function validators()
    {
        return Arr::get($this->field->stream->validators, $this->field->handle, []);
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

    public function factory(): Factory
    {
        $factory = $this->field->config('factory', $this->getFactoryName());

        return new $factory($this);
    }

    protected function getFactoryName()
    {
        return Factory::class;
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
