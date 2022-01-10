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
use Streams\Core\Entry\EntrySchema;
use Illuminate\Validation\Validator;
use Streams\Core\Entry\EntryFactory;
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

    protected function initializePrototypeAttributes(array $attributes)
    {
        return $this->initializePrototype(array_replace_recursive([
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
        return static::once($this->id . __METHOD__, fn () => $this->newRepository());
    }

    protected function newRepository(): Repository
    {
        $repository  = $this->config('repository', Repository::class);

        return new $repository($this);
    }

    public function factory(): EntryFactory
    {
        return static::once($this->id . __METHOD__, fn () => $this->newFactory());
    }

    protected function newFactory(): EntryFactory
    {
        $factory  = $this->config('factory', EntryFactory::class);

        return new $factory($this);
    }

    public function schema(): EntrySchema
    {
        return static::once($this->id . __METHOD__, fn () => $this->newSchema());
    }

    protected function newSchema(): EntrySchema
    {
        $schema  = $this->config('schema', EntrySchema::class);

        return new $schema($this);
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
        $rules = $this->gatherFieldRules();

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
                    }

                    $rule = 'unique:' . implode(',', $parameters);
                }

                /**
                 * Instantiate custom rules.
                 */
                if (strpos($rule, '\\')) {
                    $rule = new $rule;
                }
            }
        });

        return $factory->make($data, $rules);
    }

    public function config(string $key, $default = null)
    {
        return Arr::get($this->getPrototypeAttribute('config'), $key, $default);
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

        $attributes = Arr::undot($attributes);

        $this->extendInput($attributes);
        $this->importInput($attributes);
        $this->normalizeInput($attributes);

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

    public function gatherFieldRules(): array
    {
        $rules = [];

        $this->fields->each(function(Field $field) use (&$rules) {
            $rules[$field->handle] = $field->rules;
        });

        return $rules;
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
        $fields = [];

        /**
         * Minimal standardization
         */
        foreach ($this->fields ?: [] as $key => &$attributes) {
            
            $attributes = is_string($attributes) ? ['type' => $attributes] : $attributes;

            $attributes['handle'] = Arr::get($attributes, 'handle', $key);

            $attributes['stream'] = $this;

            /**
             * Process validation flags.
             */
            $rules = Arr::get($attributes, 'rules', []);

            if (Arr::get($attributes, 'required') == true) {
                $rules[] = 'required';
            }

            if (Arr::get($attributes, 'unique') == true) {
                $rules[] = 'unique';
            }

            $attributes['rules'] = $rules;
            
            if (!App::has('streams.core.field_type.' . $attributes['type'])) {
                throw new \Exception("Invalid field type [{$attributes['type']}] in stream [{$this->stream->id}].");
            }

            $field = App::make('streams.core.field_type.' . $attributes['type'], [
                'attributes' => $attributes,
            ]);

            $fields[$attributes['handle']] = $field;
        }

        $this->fields = new FieldCollection($fields);
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
