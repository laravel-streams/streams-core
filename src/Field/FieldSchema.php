<?php

namespace Streams\Core\Field;

use Illuminate\Support\Arr;
use Streams\Core\Field\Field;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\FiresCallbacks;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\ExternalDocs;

/**
 * This class helps produce JSON schema
 * for entry fields as properties.
 */
class FieldSchema
{
    use Macroable;
    use FiresCallbacks;

    protected Field $type;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    public function type(): Schema
    {
        return Schema::string($this->field->handle);
    }

    public function property(): Schema
    {
        $data = collect();

        $workflow = new Workflow([
            'start' => [$this, 'start'],
            'info' => [$this, 'info'],
            'limit' => [$this, 'limit'],
            'unique' => [$this, 'unique'],
            'pattern' => [$this, 'pattern'],
            'default' => [$this, 'default'],
            'validation' => [$this, 'validation'],
        ]);

        $this->fire('property.workflow', compact('workflow'));

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

        $schema = $schema->title(__($this->field->name()));
        $schema = $schema->description(__($this->field->description));

        // if ($this->field->docs) {
        //     $schema = $schema->externalDocs(
        //         ExternalDocs::create()->url($this->field->docs)
        //     );
        // }

        // if ($this->field->example) {
        //     $schema = $schema->example($this->field->example);
        // }

        $data->put('schema', $schema);
    }

    public function limit(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($min = $this->field->ruleParameter('min')) {
            $schema = $schema->minLength($min);
        }

        if ($max = $this->field->ruleParameter('max')) {
            $schema = $schema->maxLength($max);
        }

        $data->put('schema', $schema);
    }

    public function pattern(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($pattern = $this->field->ruleParameter('regex')) {
            $schema = $schema->pattern($pattern);
        }

        $data->put('schema', $schema);
    }

    public function default(Collection $data): void
    {
        $schema = $data->get('schema');

        if (!is_null($default = $this->field->config('default'))) {
            $schema = $schema->default($this->field->default($default));
        }

        $data->put('schema', $schema);
    }

    public function unique(Collection $data): void
    {
        $schema = $data->get('schema');

        $data->put('schema', $schema);
    }

    public function validation(Collection $data): void
    {
        $schema = $data->get('schema');

        if ($this->field->hasRule('nullable')) {
            $schema = $schema->nullable(true);
        }

        if ($value = $this->field->ruleParameter('multiple_of')) {
            $schema = $schema->multipleOf(
                strpos($value, '.') !== false ? (float) $value : (int) $value
            );
        }

        $data->put('schema', $schema);
    }
}
