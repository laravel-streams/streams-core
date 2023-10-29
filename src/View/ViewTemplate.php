<?php

namespace Streams\Core\View;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Streams\Core\Support\Facades\Applications;
use Illuminate\Contracts\View\View as ViewInterface;

/**
 * This class allows you to render arbitrary
 * strings using Larqavel's view engine.
 * 
 * Views are hashed and stored in the
 * application's storage directory.
 * 
 * ```
 * ViewTemplate::make($template, $data);
 * 
 * View::make(ViewTemplate::path($template), $data);
 * ```
 * 
 */
class ViewTemplate
{
    public static function make(string $template, array $data = [], string $extension = 'blade.php'): ViewInterface
    {
        return View::make(self::path($template, $extension), $data);
    }

    public static function path(string $template, string $extension = 'blade.php'): string
    {
        $root = 'templates/' . md5($template);

        $path = implode('/', ['streams', Applications::active()->id, $root]);

        $storage = storage_path($path);

        if (!is_dir($directory = dirname($storage))) {
            File::makeDirectory($directory, 0755, true);
        }

        if (!file_exists($storage . '.' . $extension)) {
            file_put_contents($storage . '.' . $extension, $template);
        }

        return 'storage::' . $root;
    }
}
