<?php namespace Anomaly\Streams\Platform\View\Command;

use App\Console\Kernel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Http\Request;
use TwigBridge\Bridge;

/**
 * Class ClearCache
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Command
 */
class ClearCache implements SelfHandling
{

    /**
     * Clear cache files on no-cache.
     *
     * @param Request $request
     * @param Bridge  $twig
     */
    public function handle(Request $request, Kernel $console, Bridge $twig)
    {
        if ($request->isNoCache()) {
            $console->call('cache:clear');
            $twig->clearCacheFiles();
        }
    }
}
