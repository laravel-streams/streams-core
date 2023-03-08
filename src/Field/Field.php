<?php

namespace Streams\Core\Field;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Validator;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Validation\ValidationRuleParser;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Validation\StreamsPresenceVerifier;

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

    public $stream;

    #[Field([
        'type' => 'slug',
    ])]
    public $handle;

    #[Field([
        'type' => 'string',
    ])]
    public $type;

    #[Field([
        'type' => 'object',
        'config' => [
            'default' => [],
            'wrapper' => 'array',
        ],
    ])]
    public array $config = [];

    #[Field([
        'type' => 'string',
    ])]
    public $name;

    #[Field([
        'type' => 'string',
    ])]
    public $description;

    #[Field([
        'type' => 'boolean',
    ])]
    public $protected = false;

    public function __construct(array $attributes = [])
    {
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $stream = Arr::get($attributes, 'stream');

        if ($stream && $stream instanceof Stream) {
            $this->stream = $stream;
        }

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->syncOriginalPrototypeAttributes($callbackData->get('attributes'));

        $this->setRawPrototypeAttributes($callbackData->get('attributes'));

        $this->fire('initialized', [
            'field' => $this,
        ]);
    }

    public function name(): string
    {
        return $this->name ?: ($this->name = Str::title(Str::humanize($this->handle)));
    }

    public function config(string $key, $default = null)
    {
        return Arr::get($this->getPrototypeAttribute("config"), $key, $default);
    }

    public function default($value)
    {
        return $value;
    }

    public function cast($value)
    {
        return $value;
    }

    public function modify($value)
    {
        return $value;
    }

    public function restore($value)
    {
        return $value;
    }

    public function validator($value, bool $fresh = true)
    {
        $factory = App::make(\Illuminate\Validation\Factory::class);

        $keyName = $this->config('key_name', 'id');

        $data = [$this->handle => $value];

        $factory->setPresenceVerifier(new StreamsPresenceVerifier(App::make('db')));

        $rules = $this->rules();

        array_walk($rules, function (&$rule, $key) use ($fresh, $data, $keyName) {

            if (is_string($key) && class_exists($rule)) {
                
                $rule = new $rule($this);

                return;
            }

            /**
             * Automate unique options.
             */
            if (Str::startsWith($rule, 'unique')) {

                $parts = explode(':', $rule);
                $parameters = array_filter(explode(',', Arr::get($parts, 1)));

                if (!$parameters) {
                    $parameters[] = $this->stream->id;
                }

                if (!$fresh && $key = Arr::get($data, $keyName)) {
                    $parameters[] = $key;
                    $parameters[] = $keyName;
                }

                $rule = 'unique:' . implode(',', $parameters);
            }

            if (strpos($rule, '\\')) {
                $rule = new $rule;
            }
        });

        return $factory->make($data, [$this->handle => $rules]);
    }

    public function schema(): FieldSchema
    {
        $schema = $this->config('schema') ?: $this->getSchemaName();

        return new $schema($this);
    }

    public function getSchemaName()
    {
        return FieldSchema::class;
    }

    public function decorate($value)
    {
        $name = $this->config('decorator', $this->getDecoratorName());

        if (isset($this->stream) && $this->stream instanceof Stream) {
            $this->field = $this->stream->fields->get($this->handle);
        }

        return new $name($this, $value);
    }

    public function getDecoratorName()
    {
        return FieldDecorator::class;
    }

    public function generate()
    {
        return $this->generator()->generate();
    }

    public function generator(): FieldGenerator
    {
        $generator = $this->config('generator') ?: $this->getGeneratorName();

        return new $generator($this);
    }

    public function getGeneratorName()
    {
        return FieldGenerator::class;
    }

    public function rules(): array
    {
        return $this->rules ?: [];
    }

    public function hasRule($rule): bool
    {
        return (bool) $this->getRule($rule);
    }

    public function getRule($rule)
    {
        return Arr::first($this->rules(), function ($target) use ($rule) {
            return strpos($target, $rule . ':') !== false || strpos($target, $rule) !== false;
        });
    }

    public function ruleParameters($rule): array
    {
        if (!$rule = $this->getRule($rule)) {
            return [];
        }

        [$rule, $parameters] = ValidationRuleParser::parse($rule);

        return $parameters;
    }

    public function ruleParameter($rule, $key = 0, $default = null)
    {
        return Arr::get($this->ruleParameters($rule), $key, $default);
    }

    public function isRequired(): bool
    {
        return $this->hasRule('required');
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
        $attributes = Arr::undot($attributes);
    }
}
