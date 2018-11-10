<?php namespace Anomaly\Streams\Platform\Http;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class Store
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Store extends \Symfony\Component\HttpKernel\HttpCache\Store
{

    /**
     * Generates a cache key for the given Request.
     *
     * This method should return a key that must only depend on a
     * normalized version of the request URI.
     *
     * If the same URI can have more than one representation, based on some
     * headers, use a Vary header to indicate them, and each representation will
     * be stored independently under the same cache key.
     *
     * @return string A key for the given Request
     */
    protected function generateCacheKey(Request $request)
    {
        return 'md' . hash('sha256', $request->getPathInfo());
    }

}
