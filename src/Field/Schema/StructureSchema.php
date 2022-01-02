<?php

namespace Streams\Core\Field\Schema;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class StructureSchema extends FieldSchema
{

    public function type(): Schema
    {
        $schema = Schema::object($this->type->field->handle);

        if ($items = $this->type->field->config('properties')) {
            
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

        if ($min = $this->type->field->ruleParameter('min')) {
            $schema = $schema->minItems($min);
        }

        if ($max = $this->type->field->ruleParameter('max')) {
            $schema = $schema->maxItems($max);
        }

        $data->put('schema', $schema);
    }
}
