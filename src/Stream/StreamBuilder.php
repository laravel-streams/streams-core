<?php

namespace Streams\Core\Stream;

use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Streams\Core\Support\Workflow;
use Illuminate\Support\Facades\Config;
use Streams\Core\Support\Facades\Streams;
use Streams\Core\Field\Workflows\BuildFields;

class StreamBuilder extends Workflow
{

    protected $steps = [
        'setup' => StreamBuilder::class . '@setup',
        'extend' => StreamBuilder::class . '@extend',
        'import' => StreamBuilder::class . '@import',
        'normalize' => StreamBuilder::class . '@normalize',
        'make' => StreamBuilder::class . '@make',
        'fields' => StreamBuilder::class . '@fields',
    ];

    public function setup($workflow)
    {

        /**
         * Build our components and
         * configure the application.
         */
        $stream = $workflow->stream;

        $workflow->fields = Arr::pull($stream, 'fields', []);

        $workflow->stream = $stream;
    }

    public function extend($workflow)
    {
        $stream = $workflow->stream;

        /**
         * Merge extending Stream data.
         */
        if (isset($stream['extends'])) {

            $parent = Streams::make($stream['extends'])->toArray();

            $workflow->fields = array_merge(Arr::pull($parent, 'fields', []), $workflow->fields);

            $stream = $this->merge($parent, $stream);
        }

        $workflow->stream = $stream;
    }

    public function import($workflow)
    {
        $stream = $workflow->stream;

        /**
         * Filter out the imports.
         */
        $imports = array_filter(Arr::dot($stream), function ($value) {

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
                Arr::set($stream, $key, json_decode(file_get_contents($import), true));
            }
        }

        $workflow->stream = $stream;
    }

    public function normalize($workflow)
    {
        $stream = $workflow->stream;

        /**
         * Defaults the source.
         */
        $type = Config::get('streams.sources.default', 'filebase');
        $default = Config::get('streams.sources.types.' . $type);

        if (!isset($stream['source'])) {
            $stream['source'] = $default;
        }

        if (!isset($stream['source']['type'])) {
            $stream['source']['type'] = $type;
        }

        /**
         * If only one route is defined
         * then treat it as the view route.
         */
        $route = Arr::get($stream, 'route');

        if ($route && is_string($route)) {
            $stream['route'] = [
                'view' => $route,
            ];
        }

        $stream['rules'] = array_map(function ($rules) {

            if (is_string($rules)) {
                return explode('|', $rules);
            }

            return $rules;
        }, Arr::get($stream, 'rules', []));
        

        $workflow->stream = $stream;
    }

    public function make($workflow)
    {
        $workflow->stream = new Stream($workflow->stream);
    }

    public function fields($workflow)
    {
        $fields = Arr::undot($workflow->fields);

        $fieldsWorkflow = new BuildFields();

        $fieldsWorkflow->fields = $fields;
        $fieldsWorkflow->stream = $workflow->stream;
        
        $fieldsWorkflow
            ->passThrough($workflow->object)
            ->setPrototypeAttribute('name', 'fields')
            ->process([
                'workflow' => $fieldsWorkflow
            ]);

        $stream = $workflow->stream;

        $stream->fields = $workflow->fields = $fieldsWorkflow->fields;

        $workflow->stream = $stream;
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
