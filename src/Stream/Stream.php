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
use Streams\Core\Field\FieldCollection;
use Streams\Core\Repository\Repository;
use Illuminate\Support\Traits\Macroable;
use Streams\Core\Support\Traits\Fluency;
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

    #[Field([
        'type' => 'object',
        'config' => [
            'default' => [
                'key_name' => 'id',
            ],
        ],
    ])]
    public $config = [
        'key_name' => 'id',
    ];

    #[Field([
        'type' => 'array',
        'config' => [
            'wrapper' => FieldCollection::class,
        ],
    ])]
    public $fields;

    #[Field([
        'type' => 'array',
        'config' => [
            'items' => [
                ['handle' => 'handle'],
                ['handle' => 'uri'],
                ['handle' => 'view'],
                ['handle' => 'defer'],
                ['handle' => 'parse'],
            ],
        ],
    ])]
    public $routes = [];

    public function __construct(array $attributes = [])
    {
        $callbackData = new Collection([
            'attributes' => $attributes,
        ]);

        $this->fire('initializing', [
            'callbackData' => $callbackData,
        ]);

        (new StreamBuilder())
            ->passThrough($this)
            ->process([
                'callbackData' => collect([
                    'stream' => $this,
                    'attributes' => $attributes,
                ])
            ]);

        $this->syncOriginalPrototypeAttributes($attributes);

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

    public function filesystem(string $disk): StreamFilesystem
    {
        return static::once($this->id . __METHOD__, fn () => $this->newFilesystem($disk));
    }

    protected function newFilesystem(string $disk): StreamFilesystem
    {
        $filesystem  = $this->config('filesystem', StreamFilesystem::class);

        return new $filesystem($this, $disk);
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
        $rules = $this->fields->each(function(Field $field) use ($factory) {
            
            foreach ($field->validators ?: [] as $rule => $validator) {

                $handler = Arr::get($validator, 'handler');
    
                $factory->extend(
                    $rule,
                    $this->callback($handler),
                    Arr::get($validator, 'message')
                );
            }
        })->map(function (Field $field) {
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

    protected function callback($handler): \Closure
    {
        return function ($attribute, $value, $parameters, Validator $validator) use ($handler) {

            $field = $this->fields->get($attribute);

            return App::call(
                $handler,
                [
                    'stream' => $this,
                    'value' => $value,
                    'field' => $field,
                    'attribute' => $attribute,
                    'validator' => $validator,
                    'parameters' => $parameters,
                ]
            );
        };
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
}
