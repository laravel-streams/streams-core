<?php

namespace Anomaly\Streams\Platform\Stream\Format;

use Filebase\Format\FormatInterface;

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
        dd($data);
        // $options = 0;
        // if ($pretty == true) {
        //     $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        // }

        // $encoded = json_encode($data, $options);
        // if ($encoded === false) {
        //     throw new EncodingException(
        //         "json_encode: '" . json_last_error_msg() . "'",
        //         0,
        //         null,
        //         $data
        //     );
        // }

        // return $encoded;
    }

    /**
     * Decode the data from storage.
     * 
     * @param $data
     * @return mixed
     */
    public static function decode($data)
    {
        dd($data);

        // if ($data !== false && $decoded === null) {
        //     throw new DecodingException(
        //         "json_decode: '" . json_last_error_msg() . "'",
        //         0,
        //         null,
        //         $data
        //     );
        // }

        // return $decoded;
    }
}
