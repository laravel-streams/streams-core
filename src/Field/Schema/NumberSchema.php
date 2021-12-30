<?php

namespace Streams\Core\Field\Schema;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class NumberSchema extends FieldSchema
{

    public function type(): Schema
    {
        return Schema::number($this->type->field->handle)->format(Schema::FORMAT_FLOAT);
    }

    public function limit(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($min = $this->type->field->ruleParameter('min')) {
            $schema = $schema->minimum($min);
        }

        if ($max = $this->type->field->ruleParameter('max')) {
            $schema = $schema->maximum($max);
        }

        $data->put('schema', $schema);
    }
}
