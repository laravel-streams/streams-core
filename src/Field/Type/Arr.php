<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\ArrValue;
use Streams\Core\Support\Facades\Hydrator;
use Illuminate\Contracts\Support\Arrayable;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Arr extends FieldType
{
    protected $__attributes = [
        'rules' => [
            'array',
        ],
    ];

    public function cast($value): array
    {
        if (is_string($value)) {
            return $this->castFromString($value);
        }

        if (is_object($value)) {
            return $this->castFromObject($value);
        }

        return (array) $value;
    }

    public function modify($value)
    {
        return $this->cast($value);
    }

    public function expand($value)
    {
        return new ArrValue($value);
    }

    public function schema()
    {
        $schema = Schema::array($this->field->handle);

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minItems($min);
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maxItems($max);
        }

        if ($default = $this->field->config('default')) {
            $schema = $schema->default($default);
        }

        return $schema;
    }

    public function generate()
    {
        for ($i = 0; $i < 10; $i++) {
            $values[] = $this->generator()->randomElement([
                $this->generator()->word(),
                $this->generator()->randomNumber(),
            ]);
        }

        return $values;
    }

    protected function castFromString(string $value): array
    {
        if ($json = json_decode($value, true)) {
            return $json;
        }

        if (Str::isSerialized($value, false)) {
            return (array) unserialize($value);
        }

        throw new \Exception("Could not convert string [$value] to array.");
    }

    protected function castFromObject(object $value): array
    {
        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return Hydrator::dehydrate($value);
    }
}
