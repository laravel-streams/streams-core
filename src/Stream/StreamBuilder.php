<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Streams\Core\Field\FieldCollection;
use Streams\Core\Support\Facades\Streams;

class StreamBuilder extends Workflow
{
    public array $steps = [
        'initializing' => self::class . '@initializing',
        'initialized' => self::class . '@initialized',
        'load' => self::class . '@load',
    ];

    public function initializing(Collection $callbackData)
    {
        $attributes = $callbackData->get('attributes');

        $this->extendInput($attributes);
        $this->importInput($attributes);
        $this->normalizeInput($attributes);

        $callbackData->put('attributes', $attributes);
    }

    public function initialized(Collection $callbackData)
    {
        $attributes = $callbackData->get('attributes');
        $stream = $callbackData->get('stream');

        $this->fieldsInput($attributes, $stream);

        // @todo rework to avoid this
        Arr::pull($attributes, 'fields');

        $callbackData->put('attributes', $attributes);
        $callbackData->put('stream', $stream);
    }
    
    public function load(Collection $callbackData)
    {
        $attributes = $callbackData->get('attributes');
        $stream = $callbackData->get('stream');

        $stream->loadPrototypeAttributes($attributes);

        $callbackData->put('attributes', $attributes);
        $callbackData->put('stream', $stream);
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

    public function fieldsInput(&$attributes, &$target)
    {
        $fields = [];

        /**
         * Minimal standardization
         */
        foreach ($attributes['fields'] ?: [] as $key => &$attributes) {

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
                throw new \Exception("Invalid field type [{$attributes['type']}] in stream [{$target->id}].");
            }

            $field = App::make('streams.core.field_type.' . $attributes['type'], [
                'attributes' => $attributes + ['stream' => $target],
            ]);

            $field->rules = array_unique(array_merge($field->rules(), $rules));

            $fields[$attributes['handle']] = $field;
        }

        $target->fields = new FieldCollection($fields);
    }

    protected function merge(array &$parent, array &$stream): array
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
