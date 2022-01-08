<?php

namespace Streams\Core\Field;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Streams\Core\Field\FieldType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Streams\Core\Support\Traits\FiresCallbacks;

/**
 * @property  string $handle
 * @property string $type
 * @property string $name
 * @property string $description
 */
class Field implements
    JsonSerializable,
    Arrayable,
    Jsonable
{
    use HasMemory;
    use Prototype;
    use Macroable;
    use FiresCallbacks;

    public Stream $stream;

    protected $__properties = [
        'handle' => [
            'type' => 'slug',
        ],
        'type' => [
            'type' => 'string',
        ],
        'name' => [
            'type' => 'string',
        ],
        'description' => [
            'type' => 'string',
        ],
    ];

    public function __construct(array $attributes = [])
    {
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $stream = Arr::get($attributes, 'stream');

        if (!$stream instanceof Stream) {
            $stream = new Stream($stream);
        }
        
        $this->stream = $stream;

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->initializePrototypeAttributes($callbackData->get('attributes'));

        $this->fire('initialized', [
            'field' => $this,
        ]);
    }

    public function name(): string
    {
        return $this->name ?: ($this->name = Str::title(Str::humanize($this->handle)));
    }

    public function type(array $attributes = []): FieldType
    {
        return $this->once($this->stream->id . '.' . $this->handle . '.' . $this->type, function () use ($attributes) {

            $attributes['field'] = $this;

            if (!App::has('streams.core.field_type.' . $this->type)) {
                throw new \Exception("Invalid field type [{$this->type}] in stream [{$this->stream->id}].");
            }

            $type = App::make('streams.core.field_type.' . $this->type, [
                'attributes' => $attributes,
            ]);

            return $type;
        });
    }

    public function schema(): FieldSchema
    {
        return $this->type()->schema();
    }

    public function config(string $key, $default = null)
    {
        return Arr::get($this->getPrototypeAttribute("config"), $key, $default);
    }

    public function hasRule(string $rule): bool
    {
        return $this->stream->hasRule($this->handle, $rule);
    }

    public function getRule(string $rule)
    {
        return $this->stream->getRule($this->handle, $rule);
    }

    public function ruleParameters($rule)
    {
        return $this->stream->ruleParameters($this->handle, $rule);
    }

    public function ruleParameter($rule, $key = 0)
    {
        return Arr::get($this->ruleParameters($rule), $key);
    }

    public function isRequired(): bool
    {
        return $this->stream->isRequired($this->handle);
    }

    public function toArray(): array
    {
        return Hydrator::dehydrate($this, [
            'stream',
            '__listeners',
            '__observers',
        ]);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function __toString(): string
    {
        return $this->toJson();
    }




    public function onInitializing($callbackData): void
    {
        $attributes = $callbackData->get('attributes');

        $this->normalizeInput($attributes);

        $callbackData->put('attributes', $attributes);
    }

    public function normalizeInput(&$attributes)
    {
        if (!isset($attributes['type'])) {
            $attributes['type'] = $attributes['handle'];
        }

        $attributes = Arr::undot($attributes);
    }
}
