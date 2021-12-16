<?php

namespace Streams\Core\Field;

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

    public function schema()
    {
        $schema = Schema::string($this->field->handle)
            ->description(__($this->field->description));

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minLength($min);
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maxLength($max);
        }

        if ($pattern = $this->field->hasRule('pattern')) {
            $schema = $schema->pattern($pattern);
        }

        if ($default = $this->field->config('default')) {
            $schema = $schema->default($default);
        }

        return $schema;
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
