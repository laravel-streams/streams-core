<?php

namespace Streams\Core\View;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Applications;

class ViewTemplate
{
    /**
     * Parse a string view.
     *
     * @param string $template
     * @param array $payload
     * @return View
     */
    public static function parse(string $template, array $payload = [])
    {
        $view = 'support/parsed/' . md5($template);

        $path = storage_path(implode(DIRECTORY_SEPARATOR, ['streams', Applications::handle(), $view]));

        if (!is_dir($directory = dirname($path))) {
            File::makeDirectory($directory, 0766, true);
        }

        if (!file_exists($path . '.blade.php')) {
            file_put_contents($path . '.blade.php', $template);
        }

        return View::make('storage::' . ltrim(str_replace(storage_path('streams'), '', $path), '/\\'), $payload);
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

        $base = storage_path(implode(DIRECTORY_SEPARATOR, [Applications::handle()]));

        return 'storage::' . ltrim(str_replace($base, '', $path), '\\/');
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
        $path = storage_path(
            implode(DIRECTORY_SEPARATOR, [Applications::handle(), 'support', 'streams', md5($template)])
        );

        if (!is_dir($directory = dirname($path))) {
            mkdir($directory, 0777, true);
        }

        if (!file_exists($path . '.' . $extension)) {
            file_put_contents($path . '.' . $extension, $template);
        }

        return $path;
    }
}
