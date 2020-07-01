<?php

namespace Anomaly\Streams\Platform\View;

use Anomaly\Streams\Platform\Application\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

/**
 * Class ViewTemplate
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewTemplate
{
    /**
     * Parse a string view.
     *
     * @param string $template
     * @param array $payload
     * @return View
     */
    public function parse(string $template, array $payload = [])
    {
        $view = 'support/parsed/' . md5($template);

        $path = app(Application::class)->getStoragePath($view);

        if (!is_dir($directory = dirname($path))) {
            File::makeDirectory($directory, 0766, true);
        }

        if (!file_exists($path . '.blade.php')) {
            file_put_contents($path . '.blade.php', $template);
        }

        return View::make('storage::' . $view, $payload);
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
