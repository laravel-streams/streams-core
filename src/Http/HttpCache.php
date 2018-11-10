<?php namespace Anomaly\Streams\Platform\Http;

use Anomaly\Streams\Platform\Http\Command\ClearCache;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class HttpCache
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HttpCache extends \Symfony\Component\HttpKernel\HttpCache\HttpCache
{

    use DispatchesJobs;

    /**
     * Purge a path from cache.
     *
     * @param $path
     */
    public function purge($path)
    {
        $this
            ->getStore()
            ->purge($path);

        foreach (config('streams::locales.enabled') as $locale) {
            $this
                ->getStore()
                ->purge("/{$locale}" . $path);
        }
    }

    /**
     * Clear httpcache cache.
     */
    public function clear()
    {
        $this->dispatch(new ClearCache());
    }
}
