<?php

namespace Streams\Core\Field\Schema;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class ArrSchema extends FieldSchema
{

    public function type(): Schema
    {
        return Schema::array($this->type->field->handle);
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
