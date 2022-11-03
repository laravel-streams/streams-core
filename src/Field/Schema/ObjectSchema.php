<?php

namespace Streams\Core\Field\Schema;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class ObjectSchema extends FieldSchema
{

    public function type(): Schema
    {
        $schema = Schema::object($this->field->handle);

        if ($items = $this->field->config('properties')) {
            
            $items = Streams::build([
                'fields' => $items
            ]);

            $schema = $schema->properties(...$items->schema()->properties());
        }

        return $schema;
    }

    public function limit(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minItems($this->toNumber($min));
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maxItems($this->toNumber($max));
        }

        $data->put('schema', $schema);
    }
}
