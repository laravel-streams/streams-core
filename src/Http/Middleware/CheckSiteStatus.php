<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Closure;
use Illuminate\Http\Request;

/**
 * Class CheckSiteStatus
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class CheckSiteStatus
{

    /**
     * The setting repository.
     *
     * @var SettingRepositoryInterface
     */
    protected $settings;

    /**
     * Create a new CheckSiteStatus instance.
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
        $enabled = $this->settings->get('streams::site_enabled', true);

        /**
         * Continue on if we're enabled.
         */
        if ($enabled) {
            return $next($request);
        }

        /**
         * Continue on if we're in admin.
         */
        if ($request->segment(1) == 'admin') {
            return $next($request);
        }

        /**
         * If we're disabled then we need to abort.
         */
        if (!in_array($request->getClientIp(), $this->settings->get('ip_whitelist', []))) {
            return response()->view('streams::errors/503', [], 503);
        }

        return $next($request);
    }
}
