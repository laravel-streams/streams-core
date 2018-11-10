<?php namespace Anomaly\Streams\Platform\Http;

/**
 * Class HttpCache
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class HttpCache extends \Symfony\Component\HttpKernel\HttpCache\HttpCache
{

    /**
     * Purge a path from cache.
     *
     * @param $path
     */
    public function purge($path)
    {
        $this->getStore()->purge($path);
    }
}
