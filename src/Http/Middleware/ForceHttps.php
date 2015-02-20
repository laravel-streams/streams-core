<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

/**
 * Class ForceHttps
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class ForceHttps
{

    /**
     * The setting repository.
     *
     * @var SettingRepositoryInterface
     */
    protected $settings;

    /**
     * Create a new ForceHttps instance.
     *
     * @param SettingRepositoryInterface $settings
     */
    public function __construct(SettingRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Determine if we need to force HTTPS
     * based on setting value.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $forceHttps = $this->settings->get('streams::force_https', 'none');

        /**
         * Don't force HTTPS at all.
         */
        if ($forceHttps == 'none') {
            return $next($request);
        }

        /**
         * Force all connections through HTTPS.
         */
        if ($forceHttps == 'all' && !$request->isSecure()) {
            return redirect()->secure($request->path());
        }

        /**
         * Only force public access through HTTPS.
         */
        if ($forceHttps == 'public' && !$request->isSecure() && $request->segment(1) !== 'admin') {
            return redirect()->secure($request->path());
        }

        /**
         * Only force control panel access through HTTPS.
         */
        if ($forceHttps == 'control_panel' && !$request->isSecure() && $request->segment(1) == 'admin') {
            return redirect()->secure($request->path());
        }

        // Default to whatever.
        return $next($request);
    }
}
