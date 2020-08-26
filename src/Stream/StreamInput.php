<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Anomaly\Streams\Platform\Support\Facades\Locator;

/**
 * Class StreamInput
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamInput
{

    /**
     * Read and process the stream input.
     *
     * @param array $input
     * @return array
     */
    public static function read(array $input)
    {

        /**
         * Import values matching @ which
         * refer to existing base path file.
         */
        foreach (array_filter(Arr::dot($input), function($value) {
            return strpos($value, '@') === 0;
        }) as $key => $import) {
            if (file_exists($import = base_path(substr($import, 1)))) {
                Arr::set($input, $key, json_decode(file_get_contents($import), true));
            }
        }

        /**
         * Defaults the source.
         */
        $type = Config::get('streams.sources.default', 'filebase');
        $default = Config::get('streams.sources.types.' . $type);

        if (!isset($input['source'])) {
            $input['source'] = $default;
        }

        if (!isset($input['source']['type'])) {
            $input['source']['type'] = $type;
        }

        /**
         * If only one route is defined
         * then treat it as the view route.
         */
        $route = Arr::get($input, 'route');

        if ($route && is_string($route)) {
            $input['route'] = [
                'view' => $route,
            ];
        }

        return $input;
    }
}
