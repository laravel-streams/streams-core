<?php

namespace Streams\Core\Criteria\Format;

use Illuminate\Support\Arr;
use Filebase\Format\FormatInterface;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Yaml\Yaml as Parser;

/**
 * Class Yaml
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Yaml implements FormatInterface
{

    /**
     * Get the format's file extension.
     * 
     * @return string
     */
    public static function getFileExtension()
    {
        return 'yaml';
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

        return Parser::dump($data);
    }

    /**
     * Decode the data from storage.
     * 
     * @param $data
     * @return mixed
     */
    public static function decode($data)
    {
        return [
            'data' => Parser::parse($data),
        ];
    }
}
