<?php namespace Anomaly\Streams\Platform\View\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;
use TwigBridge\Bridge;

/**
 * Class ClearTwigCache
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Command
 */
class ClearTwigCache implements SelfHandling
{

    /**
     * Clear cache files on no-cache.
     *
     * @param Request $request
     * @param Bridge  $twig
     */
    public function handle(Request $request, Bridge $twig)
    {
        if ($request->isNoCache()) {
            $twig->clearCacheFiles();
        }
    }
}
