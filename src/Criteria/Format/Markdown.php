<?php

namespace Anomaly\Streams\Platform\Criteria\Format;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;
use Filebase\Format\FormatInterface;
use Spatie\YamlFrontMatter\YamlFrontMatter;

/**
 * Class Markdown
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Markdown implements FormatInterface
{

    /**
     * Get the format's file extension.
     * 
     * @return string
     */
    public static function getFileExtension()
    {
        return 'md';
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
        $data = (array) $data;

        $body = Arr::pull($data['data'], 'body');

        $encoded = $data ? Yaml::dump(Arr::pull($data, 'data')) : null;

        // @todo swallow meta for now.
        //$encoded = Yaml::dump($data) . $encoded;

        return "---\n{$encoded}---{$body}";
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
        
        $matter = $decoded->matter();

        return [
            'data' => array_merge(Arr::get($matter, 'data', $matter), ['body' => $decoded->body()])
        ];
    }
}
