<?php

namespace Streams\Core\Field;

use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class FieldSchema
{
    use Macroable;
    use FiresCallbacks;

    protected FieldType $type;

    public function __construct(FieldType $type)
    {
        $this->type = $type;
    }

    public function type(): Schema
    {
        return Schema::string($this->type->field->handle);
    }

    public function property(): Schema
    {
        $data = collect();

        $workflow = new Workflow([
            'start' => [$this, 'start'],
            'info' => [$this, 'info'],
            'limit' => [$this, 'limit'],
            'pattern' => [$this, 'pattern'],
            'default' => [$this, 'default'],
            'validation' => [$this, 'validation'],
        ]);

        $workflow
            ->passThrough($this)
            ->process(['data' => $data]);

        return $data->get('schema');
    }

    public function start(Collection $data): void
    {
        $data->put('schema', $this->type());
    }

    public function info(Collection $data): void
    {
        $schema = $data->get('schema');

        $schema = $schema->title(__($this->type->field->name()));
        $schema = $schema->description(__($this->type->field->description));

        if ($this->type->field->docs) {
            $schema = $schema->externalDocs(
                ExternalDocs::create()->url($this->type->field->docs)
            );
        }

        $data->put('schema', $schema);
    }

    public function limit(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($min = $this->type->field->ruleParameter('min')) {
            $schema = $schema->minLength($min);
        }

        if ($max = $this->type->field->ruleParameter('max')) {
            $schema = $schema->maxLength($max);
        }

        $data->put('schema', $schema);
    }

    public function pattern(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($pattern = $this->type->field->ruleParameter('regex')) {
            $schema = $schema->pattern($pattern);
        }

        $data->put('schema', $schema);
    }

    public function default(Collection $data): void
    {
        $schema = $data->get('schema');

        if (!is_null($default = $this->type->field->config('default'))) {
            $schema = $schema->default($this->type->default($default));
        }

        $data->put('schema', $schema);
    }

    public function validation(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($this->type->field->hasRule('nullable')) {
            $schema = $schema->nullable(true);
        }

        if ($value = $this->type->field->ruleParameter('multiple_of')) {
            $schema = $schema->multipleOf(
                strpos($value, '.') !== false ? (float) $value : (int) $value
            );
        }

        $data->put('schema', $schema);
    }
}
