<?php

namespace Anomaly\Streams\Platform\Criteria\Format;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;
use Filebase\Format\FormatInterface;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/**
 * Class Blade
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Blade implements FormatInterface
{

    /**
     * Get the format's file extension.
     * 
     * @return string
     */
    public static function getFileExtension()
    {
        return 'php';
    }

    /**
     * Encode the data for storage.
     * 
     * @param array $data
     * @param bool $pretty
     * @return string
     */
    public static function encode($data = [], $pretty = true)
    {
        $body = Arr::pull($data, 'body');

        $encoded = Yaml::dump($data);

        return "---\n{$encoded}\n---{$body}";
    }

    /**
     * Decode the data from storage.
     * 
     * @param $data
     * @return mixed
     */
    public static function decode($data)
    {
        $decoded = YamlFrontMatter::parse($data);

        return [
            'data' => array_merge($decoded->matter(), ['body' => $decoded->body()])
        ];
    }
}
