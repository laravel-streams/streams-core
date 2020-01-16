<?php

namespace Anomaly\Streams\Platform\Support;

/**
 * Class Template
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Template
{

    /**
     * Render a string template.
     *
     * @param       $template
     * @param array $payload
     * @return string
     */
    public static function render($template, array $payload = [])
    {
        $path = self::path($template);

        return view(
            'storage::' . ltrim(
                str_replace(application()->getStoragePath(), '', $path),
                '\\/'
            ),
            $payload
        )->render();
    }

    /**
     * Make a string template.
     *
     * @param       $template
     * @param string $extension
     * @return string
     */
    public static function make($template, $extension = 'blade.php')
    {
        $path = self::path($template, $extension);

        return 'storage::' . ltrim(
            str_replace(application()->getStoragePath(), '', $path),
            '\\/'
        );
    }

    /**
     * Return the path to a string template.
     *
     * @param $template
     * @param string $extension
     * @return string
     */
    public static function path($template, $extension = 'blade.php')
    {
        $path = application()->getStoragePath('support/parsed/' . md5($template));

        if (!is_dir($directory = dirname($path))) {
            mkdir($directory, 0777, true);
        }

        if (!file_exists($path . '.' . $extension)) {
            file_put_contents($path . '.' . $extension, $template);
        }

        return $path;
    }
}
