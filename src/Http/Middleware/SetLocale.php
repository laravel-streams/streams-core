<?php namespace Anomaly\Streams\Platform\Http\Middleware;

use Anomaly\PreferencesModule\Preference\Contract\PreferenceRepositoryInterface;
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
     * The preference repository.
     *
     * @var PreferenceRepositoryInterface
     */
    protected $preferences;

    /**
     * The Laravel application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new SetLocale instance.
     *
     * @param Repository                    $config
     * @param SettingRepositoryInterface    $settings
     * @param PreferenceRepositoryInterface $preferences
     * @param Application                   $application
     */
    public function __construct(
        Repository $config,
        SettingRepositoryInterface $settings,
        PreferenceRepositoryInterface $preferences,
        Application $application
    ) {
        $this->config      = $config;
        $this->settings    = $settings;
        $this->preferences = $preferences;
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
            $this->preferences->get(
                'streams::locale',
                $this->settings->get(
                    'streams::default_locale',
                    $this->config->get('app.fallback_locale')
                )
            )
        );

        $this->config->set(
            'streams::default_locale',
            $this->settings->get(
                'streams::default_locale',
                $this->config->get('app.fallback_locale')
            )
        );

        return $next($request);
    }
}
