<?php

namespace Streams\Core\Schema\Types;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Streams\Core\Support\Facades\Streams;

class ArrSchema extends FieldSchema
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
}
