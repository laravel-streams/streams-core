<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

/**
 * Class WritableDirectories
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class WritableDirectories implements Middleware
{

    /**
     * Writable directories.
     *
     * @var array
     */
    protected $directories = [
        'public/assets',
        'storage/cache',
        'storage/framework',
    ];

    /**
     * Writable files.
     *
     * @var array
     */
    protected $files = [];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (config('app.debug')) {

            foreach ($this->directories as $directory) {

                chmod(base_path($directory), 777);
            }

            foreach ($this->files as $file) {

                chmod(base_path($file), 777);
            }
        }

        return $next($request);
    }
}
 