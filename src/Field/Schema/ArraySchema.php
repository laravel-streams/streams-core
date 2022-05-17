<?php

namespace Streams\Core\Field\Schema;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use Streams\Core\Support\Facades\Streams;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class ArraySchema extends FieldSchema
{

    public function type(): Schema
    {
        $schema = Schema::array($this->field->handle);

        if ($items = $this->field->config('items')) {
            
            $items = Streams::build([
                'fields' => $items
            ]);

            $schema = $schema->items($items->schema()->object());
        }

        return $schema;
    }

    public function limit(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minItems($min);
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maxItems($max);
        }

        $data->put('schema', $schema);
    }

    public function unique(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($this->field->hasRule('unique')) {
            $schema = $schema->uniqueItems(true);
        }

        $data->put('schema', $schema);
    }

    public function getSchemaName()
    {
        return ArraySchema::class;
    }
}
