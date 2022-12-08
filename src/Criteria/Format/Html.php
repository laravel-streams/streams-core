<?php

namespace Streams\Core\Criteria\Format;

use Illuminate\Support\Arr;
use Symfony\Component\Yaml\Yaml;
use Filebase\Format\FormatInterface;

class Html implements FormatInterface
{

    /**
     * Get the format's file extension.
     * 
     * @return string
     */
    public static function getFileExtension()
    {
        return 'html';
    }

    /**
     * Encode the data for storage.
     * 
     * @param array $data
     * @param bool $pretty
     * @return string
     */
    public static function encode($data, $pretty)
    {
        $meta = (array) $data;

        $data = Arr::pull($meta, 'data', []);

        $data = array_merge($meta, $data);

        Arr::pull($data, '__created_at');
        Arr::pull($data, '__updated_at');

        $body = Arr::pull($data, 'body');

        $encoded = $data ? Yaml::dump($data) : null;

        return "---\n{$encoded}---\n{$body}";
    }

    /**
     * Decode the data from storage.
     * 
     * @param $data
     * @return mixed
     */
    public static function decode($data)
    {
        $pattern = '/^[\s\r\n]?---[\s\r\n]?$/sm';

        $parts = preg_split($pattern, PHP_EOL . ltrim($data));

        if (count($parts) < 3) {
            return ['data' => ['body' => $data]];
        }

        if (!$matter = json_decode(trim($parts[1]), true)) {
            $matter = Yaml::parse(trim($parts[1]));
        }

        $body = implode(PHP_EOL . '---' . PHP_EOL, array_slice($parts, 2));

        return [
            'data' => array_merge(Arr::get($matter, 'data', $matter), ['body' => $body])
        ];
    }
}
