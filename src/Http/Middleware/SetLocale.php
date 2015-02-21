<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\SettingsModule\Setting\Contract\SettingRepositoryInterface;
use Closure;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

/**
 * Class SetLocale
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Http\Middleware
 */
class SetLocale
{

    /**
     * The configuration repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The setting repository.
     *
     * @var SettingRepositoryInterface
     */
    protected $settings;

    /**
     * The Laravel application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new SetLocale instance.
     *
     * @param Repository                 $config
     * @param SettingRepositoryInterface $settings
     * @param Application                $application
     */
    public function __construct(Repository $config, SettingRepositoryInterface $settings, Application $application)
    {
        $this->config      = $config;
        $this->settings    = $settings;
        $this->application = $application;
    }

    /**
     * Set the application locale based
     * on settings and configuration.
     *
     * @param  Request  $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->application->setLocale(
            $this->settings->get('streams::default_locale', $this->config->get('app.locale'))
        );

        return $next($request);
    }
}
