<?php

namespace Streams\Core\Stream;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Illuminate\Support\Collection;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\App;
use Streams\Core\Criteria\Criteria;
use Illuminate\Validation\Validator;
use Streams\Core\Stream\StreamCache;
use Illuminate\Support\Facades\Config;
use Streams\Core\Field\FieldCollection;
use Streams\Core\Repository\Repository;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Fluency;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Validation\StreamsPresenceVerifier;

class Stream implements
    JsonSerializable,
    Arrayable,
    Jsonable
{

    use Fluency;
    use HasMemory;
    use Macroable;
    use ForwardsCalls;
    use FiresCallbacks;

    protected $__attributes = [
        'config' => [
            'key_name' => 'id',
            'created_at_name' => false,
            'updated_at_name' => false,
            'created_by_name' => false,
            'updated_by_name' => false,
        ],
    ];

    protected $__properties = [
        'config' => [
            'type' => 'object',
            'config' => [
                'default' => [
                    'key_name' => 'id',
                ],
            ],
        ],
        'fields' => [
            'type' => 'array',
            'config' => [
                'wrapper' => FieldCollection::class,
            ],
        ],
    ];

    public function __construct(array $attributes = [])
    {
        $attributes = array_replace_recursive($this->__attributes, $attributes);

        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->syncOriginalPrototypeAttributes($attributes);

        $this->loadPrototypeAttributes($callbackData->get('attributes'));

        $this->loadPrototypeProperties($this->__properties);

        $this->fire('initialized', [
            'stream' => $this,
        ]);
    }

    public function name()
    {
        return $this->name ?: Str::title(Str::humanize($this->id));
    }

    public function getIdAttribute()
    {
        return $this->getPrototypeAttributeValue('id') ?: $this->getPrototypeAttributeValue('handle');
    }

    public function getHandleAttribute()
    {
        return $this->getPrototypeAttributeValue('handle') ?: $this->getPrototypeAttributeValue('id');
    }

    public function entries(): Criteria
    {
        return $this
            ->repository()
            ->newCriteria();
    }

    public function schema(): StreamSchema
    {
        return static::once($this->id . __METHOD__, fn () => $this->newSchema());
    }

    protected function newSchema(): StreamSchema
    {
        $schema  = $this->config('schema', StreamSchema::class);

        return new $schema($this);
    }

    public function repository(): Repository
    {
        return static::once($this->id . __METHOD__, fn () => $this->newRepository());
    }

    protected function newRepository(): Repository
    {
        $repository  = $this->config('repository', Repository::class);

        return new $repository($this);
    }

    public function validator($data, $fresh = true): Validator
    {
        $data = Arr::make($data);

        $factory = App::make(Factory::class);

        $keyName = $this->config('key_name', 'id');

        $factory->setPresenceVerifier(new StreamsPresenceVerifier(App::make('db')));

        /**
         * https://gph.is/g/Eqn635a
         */
        $rules = $this->fields->map(function (Field $field) {
            return $field->rules;
        })->all();

        array_walk($rules, function (&$rules, $field) use ($fresh, $data, $keyName) {

            foreach ($rules as &$rule) {

                /**
                 * Automate unique options.
                 */
                if (Str::startsWith($rule, 'unique')) {

                    $parts = explode(':', $rule);
                    $parameters = array_filter(explode(',', Arr::get($parts, 1)));

                    if (!$parameters) {
                        $parameters[] = $this->id;
                    }

                    if (count($parameters) === 1) {
                        $parameters[] = $field;
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
            }
        });

        return $factory->make($data, $rules);
    }

    public function config(string $key, $default = null)
    {
        return Arr::get((array) $this->getPrototypeAttribute('config'), $key, $default);
    }

    public function cache(): StreamCache
    {
        return static::once($this->id . __METHOD__, fn () => new StreamCache($this));
    }

    public function toArray(): array
    {
        return Arr::make(Hydrator::dehydrate($this, [
            '__listeners',
            '__observers',
            '__created_at',
            '__updated_at',
        ]));
    }

    public function toJson($options = 0): string
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function __toString(): string
    {
        return $this->toJson();
    }



    public function onInitializing($callbackData)
    {
        $attributes = $callbackData->get('attributes');

        $this->extendInput($attributes);
        $this->importInput($attributes);
        $this->normalizeInput($attributes);

        $callbackData->put('attributes', $attributes);
    }

    public function onInitialized()
    {
        $this->fieldsInput();
    }

    public function extendInput(&$attributes)
    {

        /**
         * Merge extending Stream data.
         */
        if (isset($attributes['extends'])) {

            $parent = Streams::make($attributes['extends'])->getOriginalPrototypeAttributes();

            $attributes['fields'] = array_merge(Arr::pull($parent, 'fields', []), Arr::get($attributes, 'fields', []));

            $attributes = $this->merge($parent, $attributes);
        }
    }

    public function importInput(&$attributes)
    {

        /**
         * Filter out the imports.
         */
        $imports = array_filter(Arr::dot($attributes), function ($value) {

            if (!is_string($value)) {
                return false;
            }

            return strpos($value, '@') === 0;
        });

        /**
         * Import values matching @ which
         * refer to existing base path file.
         */
        foreach ($imports as $key => $import) {
            if (file_exists($import = base_path(substr($import, 1)))) {
                Arr::set($attributes, $key, json_decode(file_get_contents($import), true));
            }
        }
    }

    public function normalizeInput(&$attributes)
    {

        /**
         * Defaults the source.
         */
        $type = Config::get('streams.core.default_source', 'filebase');
        $default = Config::get('streams.core.sources.types.' . $type);

        if (!array_key_exists('source', $attributes)) {
            $attributes['source'] = $default;
        }

        if (!isset($attributes['source']['type'])) {
            $attributes['source']['type'] = $type;
        }

        /**
         * If only one route is defined
         * then treat it as the view route.
         */
        $route = Arr::get($attributes, 'route');

        if ($route && is_string($route)) {
            $attributes['routes'] = [
                'view' => $route,
            ];
        }

        $attributes['rules'] = array_map(function ($rules) {

            if (is_string($rules)) {
                return explode('|', $rules);
            }

            return $rules;
        }, Arr::get($attributes, 'rules', []));
    }

    public function fieldsInput()
    {
        $fields = [];

        $this->__prototype['original']['fields'] = [];

        /**
         * Minimal standardization
         */
        foreach ($this->fields ?: [] as $key => &$attributes) {

            $attributes = is_string($attributes) ? ['type' => $attributes] : $attributes;

            $attributes['handle'] = Arr::get($attributes, 'handle', $key);

            /**
             * Process validation flags.
             */
            $rules = Arr::pull($attributes, 'rules', []);

            if (Arr::pull($attributes, 'required') == true) {
                $rules[] = 'required';
            }

            if (Arr::pull($attributes, 'unique') == true) {
                $rules[] = 'unique';
            }

            if (!array_key_exists('type', $attributes)) {
                $attributes['type'] = 'string';
            }

            if (!App::has('streams.core.field_type.' . $attributes['type'])) {
                throw new \Exception("Invalid field type [{$attributes['type']}] in stream [{$this->id}].");
            }

            $field = App::make('streams.core.field_type.' . $attributes['type'], [
                'attributes' => $attributes + ['stream' => $this],
            ]);

            $field->rules = array_unique(array_merge($field->rules(), $rules));

            $fields[$attributes['handle']] = $field;

            // Sync originals with fully expanded field definitions.
            $this->__prototype['original']['fields'][$attributes['handle']] = $attributes;
        }

        $this->setPrototypeAttributeValue('fields', new FieldCollection($fields));
    }

    public function merge(array &$parent, array &$stream)
    {
        $merged = $parent;

        foreach ($stream as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->merge($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }
}
