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

        if (!$enabled && !in_array($request->getClientIp(), $this->settings->get('ip_whitelist', []))) {
            abort(404);
        }

        // Default to whatever.
        return $next($request);
    }
}
