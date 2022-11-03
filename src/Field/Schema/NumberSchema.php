<?php

namespace Streams\Core\Field\Schema;

use Illuminate\Support\Collection;
use Streams\Core\Field\FieldSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class NumberSchema extends FieldSchema
{

    public function type(): Schema
    {
        return Schema::number($this->field->handle)->format(Schema::FORMAT_FLOAT);
    }

    public function limit(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minimum($this->toNumber($min));
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maximum($this->toNumber($max));
        }

        $data->put('schema', $schema);
    }
}
