<?php

namespace Streams\Core\Stream;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Illuminate\Support\Collection;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\App;
use Streams\Core\Criteria\Criteria;
use Illuminate\Validation\Validator;
use Streams\Core\Entry\EntryFactory;
use Illuminate\Support\Facades\Config;
use Streams\Core\Field\FieldCollection;
use Streams\Core\Repository\Repository;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Fluency;
use Streams\Core\Support\Facades\Streams;
use Illuminate\Contracts\Support\Jsonable;
use Streams\Core\Support\Facades\Hydrator;
use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\Prototype;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Validation\ValidationRuleParser;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Core\Validation\StreamsPresenceVerifier;

class Stream implements
    JsonSerializable,
    ArrayAccess,
    Arrayable,
    Jsonable
{

    use Prototype {
        Prototype::initializePrototypeAttributes as private initializePrototype;
    }

    use Fluency;
    use HasMemory;
    use Macroable;
    use ForwardsCalls;
    use FiresCallbacks;

    public function __construct(array $attributes = [])
    {
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        $this->initializePrototypeAttributes($callbackData->get('attributes'));

        $this->fire('initialized', [
            'stream' => $this,
        ]);
    }

    public function getIdAttribute()
    {
        return $this->getPrototypeAttributeValue('id') ?: $this->getPrototypeAttributeValue('handle');
    }

    public function getHandleAttribute()
    {
        return $this->getPrototypeAttributeValue('handle') ?: $this->getPrototypeAttributeValue('id');
    }

    protected function initializePrototypeAttributes(array $attributes)
    {
        return $this->initializePrototype(array_merge([
            'handle' => null,
            'routes' => [],
            'rules' => [],
            'validators' => [],
            'config' => [
                'key_name' => 'id',
            ],
        ], $attributes));
    }


    public function entries(): Criteria
    {
        return $this
            ->repository()
            ->newCriteria();
    }

    public function repository(): Repository
    {
        return $this->once($this->id . __METHOD__, fn () => $this->newRepository());
    }

    protected function newRepository(): Repository
    {
        $repository  = $this->config('repository', Repository::class);

        return new $repository($this);
    }

    public function factory(): EntryFactory
    {
        return $this->once($this->id . __METHOD__, fn () => $this->newFactory());
    }

    protected function newFactory(): EntryFactory
    {
        $factory  = $this->config('factory', EntryFactory::class);

        return new $factory($this);
    }

    public function validator($data): Validator
    {
        $data = Arr::make($data);

        $factory = App::make(Factory::class);

        $factory->setPresenceVerifier(new StreamsPresenceVerifier(App::make('db')));

        /**
         * https://gph.is/g/Eqn635a
         */
        $rules = $this->getPrototypeAttribute('rules') ?: [];
        $validators = $this->getPrototypeAttribute('validators') ?: [];

        /**
         * Automate Unique Rule
         */
        array_walk($rules, function (&$rules, $field) {

            foreach ($rules as &$rule) {

                if (Str::startsWith($rule, 'unique')) {

                    $parts = explode(':', $rule);
                    $parameters = array_filter(explode(',', Arr::get($parts, 1)));

                    if (!$parameters) {
                        $parameters[] = $this->id;
                    }

                    if (count($parameters) === 1) {
                        $parameters[] = $field;
                    }

                    $rule = 'unique:' . implode(',', $parameters);
                }
            }
        });

        $rules = array_map(function ($rules) {
            return implode('|', $rules);
        }, $rules);

        /**
         * Extend the factory with custom validators.
         */
        foreach ($this->fields->keys() as $field) {
            foreach (Arr::get($validators, $field, []) as $rule => $validator) {

                if (is_string($validator)) {
                    $validator = [
                        'handler' => $validator,
                    ];
                }

                $handler = Arr::get($validator, 'handler');
                $message = Arr::get($validator, 'message');

                $handler = function ($attribute, $value, $parameters, Validator $validator) use ($handler) {

                    return App::call(
                        $handler,
                        [
                            'value' => $value,
                            'attribute' => $attribute,
                            'validator' => $validator,
                            'parameters' => $parameters,
                        ],
                        'handle'
                    );
                };

                $factory->extend(
                    $rule,
                    $handler,
                    $message
                );
            }
        }

        return $factory->make($data, $rules);
    }

    public function hasRule($field, $rule): bool
    {
        return (bool) $this->getRule($field, $rule);
    }

    public function getRule($field, $rule)
    {
        $rules = Arr::get($this->rules, $field, []);

        return Arr::first($rules, function ($target) use ($rule) {
            return strpos($target, $rule . ':') !== false || strpos($target, $rule) !== false;
        });
    }

    public function ruleParameters($field, $rule): array
    {
        if (!$rule = $this->getRule($field, $rule)) {
            return [];
        }

        [$rule, $parameters] = ValidationRuleParser::parse($rule);

        return $parameters;
    }

    public function ruleParameter($field, $rule, $key = 0)
    {
        return Arr::get($this->ruleParameters($field, $rule), $key);
    }

    public function isRequired($field)
    {
        return $this->hasRule($field, 'required');
    }

    public function config(string $key, $default = null)
    {
        return Arr::get($this->config, $key, $default);
    }

    public function cache(): StreamCache
    {
        return $this->once($this->id . __METHOD__, fn () => new StreamCache($this));
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

        $attributes = Arr::undot($attributes);

        $this->extendInput($attributes);
        $this->importInput($attributes);
        $this->normalizeInput($attributes);
        $this->consolidateValidation($attributes);

        $this->adjustInput($attributes);

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

            $parent = Streams::make($attributes['extends'])->toArray();

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

        if (!isset($attributes['source'])) {
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

    public function consolidateValidation(&$attributes)
    {
        $rules = Arr::get($attributes, 'rules', []);
        $validators = Arr::get($attributes, 'validators', []);

        $fields = Arr::get($attributes, 'fields', []);

        $fieldRules = array_filter(
            array_combine(array_keys($fields), array_map(function ($field) {

                $rules = Arr::get($field, 'rules', []);

                if (Arr::get($field, 'required') == true) {
                    $rules[] = 'required';
                }

                if (Arr::get($field, 'unique') == true) {
                    $rules[] = 'unique';
                }

                return $rules;
            }, $fields))
        );

        $fieldValidators = array_filter(
            array_combine(array_keys($fields), array_map(function ($field) {

                $validators = Arr::get($field, 'validators', []);

                return $validators;
            }, $fields))
        );

        foreach ($fieldRules as $field => $configured) {
            $rules[$field] = array_unique(array_merge(Arr::get($rules, $field, []), $configured));
        }

        foreach ($fieldValidators as $field => $configured) {
            $validators[$field] = array_unique(array_merge(Arr::get($validators, $field, []), $configured));
        }
    }

    public function adjustInput(&$attributes)
    {

        // Push to config
        // @todo remove this at some point ^_^
        Arr::set($attributes, 'config.source', Arr::get($attributes, 'config.source', Arr::pull($attributes, 'source', [])));
        if ($source = Arr::pull($attributes, 'source')) {
            Arr::set($attributes, 'config.source', $source);
        }

        if ($abstract = Arr::pull($attributes, 'abstract')) {
            Arr::set($attributes, 'config.abstract', $abstract);
        }
    }

    public function fieldsInput()
    {

        $fields = $this->fields ?: [];

        /**
         * Minimal standardization
         */
        array_walk($fields, function (&$field, $key) {

            $field = is_string($field) ? ['type' => $field] : $field;

            $field['handle'] = Arr::get($field, 'handle', $key);

            $field['stream'] = $this;

            $field = new Field($field);
        });

        $this->fields = new FieldCollection($fields);

        /**
         * Load rules from fields
         * and types into the stream.
         */
        $rules = $this->rules;
        $validators = $this->validators;

        $this->fields->each(function ($field, $handle) use (&$rules, &$validators) {

            if ($fieldRules = $field->rules) {
                $rules[$handle] = array_merge(
                    Arr::pull($rules, $handle, []),
                    $fieldRules
                );
            }

            if ($fieldTypeRules = $field->type()->rules) {
                $rules[$handle] = array_merge(
                    Arr::pull($rules, $handle, []),
                    $fieldTypeRules
                );
            }

            if ($fieldValidators = $field->type()->validators) {
                $validators[$handle] = array_merge(
                    Arr::pull($validators, $handle, []),
                    $fieldValidators
                );
            }

            if ($fieldTypeValidators = $field->type()->validators) {
                $validators[$handle] = array_merge(
                    Arr::pull($validators, $handle, []),
                    $fieldTypeValidators
                );
            }
        });

        $this->rules = $rules;
        $this->validators = $validators;
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
