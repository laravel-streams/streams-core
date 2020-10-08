<?php

namespace Anomaly\Streams\Platform\Stream\Workflows;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Support\Workflow;
use Anomaly\Streams\Platform\Support\Facades\Streams;
use Anomaly\Streams\Platform\Field\Workflows\BuildFields;

/**
 * Class BuildStream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BuildStream extends Workflow
{

    protected $steps = [
        'setup' => BuildStream::class . '@setup',
        'extend' => BuildStream::class . '@extend',
        'normalize' => BuildStream::class . '@normalize',
        'make' => BuildStream::class . '@make',
        'fields' => BuildStream::class . '@fields',
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

    public function normalize($workflow)
    {
        $stream = $workflow->stream;

        $filtered = array_filter(Arr::dot($stream), function ($value) {

            if (!is_string($value)) {
                return false;
            }

            return strpos($value, '@') === 0;
        });

        /**
         * Import values matching @ which
         * refer to existing base path file.
         */
        foreach ($filtered as $key => $import) {
            if (file_exists($import = base_path(substr($import, 1)))) {
                Arr::set($stream, $key, json_decode(file_get_contents($import), true));
            }
        }

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

        $fieldsWorkflow->process([
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
