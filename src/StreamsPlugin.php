<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Entry\Command\GetEntryCriteria;
use Anomaly\Streams\Platform\Image\Command\MakeImagePath;
use Anomaly\Streams\Platform\Image\Command\MakeImageTag;
use Anomaly\Streams\Platform\Image\Command\MakeImageUrl;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Ui\Button\Command\GetButtons;
use Anomaly\Streams\Platform\Ui\Command\GetElapsedTime;
use Anomaly\Streams\Platform\Ui\Command\GetMemoryUsage;
use Anomaly\Streams\Platform\Ui\Command\GetTranslatedString;
use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;
use Anomaly\Streams\Platform\Ui\Icon\Command\GetIcon;
use Anomaly\Streams\Platform\View\Command\GetConstants;
use Anomaly\Streams\Platform\View\Command\GetLayoutName;
use Anomaly\Streams\Platform\View\Command\GetView;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Translation\Translator;
use Jenssegers\Agent\Agent;

/**
 * Class StreamsPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsPlugin extends Plugin
{

    /**
     * The string utility.
     *
     * @var Str
     */
    protected $str;

    /**
     * The URL generator.
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * The auth guard.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * The agent utility.
     *
     * @var Agent
     */
    protected $agent;

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The session store.
     *
     * @var Store
     */
    protected $session;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new AgentPlugin instance.
     *
     * @param UrlGenerator $url
     * @param Str          $str
     * @param Guard        $auth
     * @param Agent        $agent
     * @param Asset        $asset
     * @param Image        $image
     * @param Repository   $config
     * @param Request      $request
     * @param Store        $session
     */
    public function __construct(
        UrlGenerator $url,
        Str $str,
        Guard $auth,
        Agent $agent,
        Asset $asset,
        Image $image,
        Repository $config,
        Request $request,
        Store $session
    ) {
        $this->url     = $url;
        $this->str     = $str;
        $this->auth    = $auth;
        $this->agent   = $agent;
        $this->asset   = $asset;
        $this->image   = $image;
        $this->config  = $config;
        $this->request = $request;
        $this->session = $session;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'entry',
                function ($namespace, $stream = null) {
                    return (new Decorator())->decorate(
                        $this->dispatch(new GetEntryCriteria($namespace, $stream ?: $namespace, 'first'))
                    );
                }
            ),
            new \Twig_SimpleFunction(
                'entries',
                function ($namespace, $stream = null) {
                    return (new Decorator())->decorate(
                        $this->dispatch(new GetEntryCriteria($namespace, $stream ?: $namespace, 'get'))
                    );
                }
            ),
            new \Twig_SimpleFunction(
                'image_path',
                function ($image) {
                    return $this->dispatch(new MakeImagePath($image));
                }
            ),
            new \Twig_SimpleFunction(
                'image_url',
                function ($image) {
                    return $this->dispatch(new MakeImageUrl($image));
                }
            ),
            new \Twig_SimpleFunction(
                'image',
                function ($image) {
                    return $this->dispatch(new MakeImageTag($image));
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'img',
                function ($image) {
                    return $this->dispatch(new MakeImageTag($image));
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'form',
                function ($parameters) {
                    return $this->dispatch(new GetFormCriteria($parameters));
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'icon',
                function ($type, $class = null) {
                    return (new Decorator())->decorate($this->dispatch(new GetIcon($type, $class)));
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'view',
                function ($view, array $data = []) {
                    return $this->dispatch(new GetView($view, $data))->render();
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'buttons',
                function ($buttons) {
                    return $this->dispatch(new GetButtons($buttons))->render();
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'constants',
                function () {
                    return $this->dispatch(new GetConstants())->render();
                },
                [
                    'is_safe' => ['html']
                ]
            ),
            new \Twig_SimpleFunction(
                'env',
                function ($key, $default = null) {
                    return env($key, $default);
                }
            ),
            new \Twig_SimpleFunction(
                'decorate',
                function ($value) {
                    return (new Decorator())->decorate($value);
                }
            ),
            new \Twig_SimpleFunction(
                'request_time',
                function ($decimal = 2) {
                    return $this->dispatch(new GetElapsedTime($decimal));
                }
            ),
            new \Twig_SimpleFunction(
                'memory_usage',
                function ($precision = 1) {
                    return $this->dispatch(new GetMemoryUsage($precision));
                }
            ),
            new \Twig_SimpleFunction(
                'layout',
                function ($layout, $default = 'default') {
                    return $this->dispatch(new GetLayoutName($layout, $default));
                }
            ),
            new \Twig_SimpleFunction(
                'request_*',
                function ($name) {

                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->request, camel_case($name)], $arguments);
                }
            ),
            new \Twig_SimpleFunction(
                'trans',
                function ($key, array $parameters = [], $locale = 'en') {
                    return $this->dispatch(new GetTranslatedString($key, $parameters, $locale));
                }
            ),
            new \Twig_SimpleFunction(
                'str_*',
                function ($name) {

                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->str, camel_case($name)], $arguments);
                }
            ),
            new \Twig_SimpleFunction(
                'url_*',
                function ($name) {

                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->url, camel_case($name)], $arguments);
                }
            ),
            new \Twig_SimpleFunction(
                'addons',
                function ($type = null) {

                    $addons = app(AddonCollection::class);

                    if ($type) {
                        $addons = $addons->{str_plural($type)}();
                    }

                    return $addons;
                }
            ),
            new \Twig_SimpleFunction('config', [$this->config, 'get']),
            new \Twig_SimpleFunction('config_get', [$this->config, 'get']),
            new \Twig_SimpleFunction('config_has', [$this->config, 'has']),
            new \Twig_SimpleFunction('auth_user', [$this->auth, 'user']),
            new \Twig_SimpleFunction('auth_check', [$this->auth, 'check']),
            new \Twig_SimpleFunction('auth_guest', [$this->auth, 'guest']),
            new \Twig_SimpleFunction('trans_exists', [$this->translator, 'exists']),
            new \Twig_SimpleFunction('message_get', [$this->session, 'pull']),
            new \Twig_SimpleFunction('message_exists', [$this->session, 'has']),
            new \Twig_SimpleFunction('session', [$this->session, 'get']),
            new \Twig_SimpleFunction('csrf_token', [$this->session, 'token'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('csrf_field', 'csrf_field', ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('session_get', [$this->session, 'get']),
            new \Twig_SimpleFunction('session_pull', [$this->session, 'pull']),
            new \Twig_SimpleFunction('session_has', [$this->session, 'has']),
            new \Twig_SimpleFunction('agent_device', [$this->agent, 'device']),
            new \Twig_SimpleFunction('agent_browser', [$this->agent, 'browser']),
            new \Twig_SimpleFunction('agent_platform', [$this->agent, 'platform']),
            new \Twig_SimpleFunction('agent_is_phone', [$this->agent, 'isPhone']),
            new \Twig_SimpleFunction('agent_is_robot', [$this->agent, 'isRobot']),
            new \Twig_SimpleFunction('agent_is_tablet', [$this->agent, 'isTablet']),
            new \Twig_SimpleFunction('agent_is_mobile', [$this->agent, 'isMobile']),
            new \Twig_SimpleFunction('agent_is_desktop', [$this->agent, 'isDesktop']),
            new \Twig_SimpleFunction('asset_add', [$this->asset, 'add']),
            new \Twig_SimpleFunction('asset_url', [$this->asset, 'url']),
            new \Twig_SimpleFunction('asset_urls', [$this->asset, 'urls']),
            new \Twig_SimpleFunction('asset_path', [$this->asset, 'path']),
            new \Twig_SimpleFunction('asset_paths', [$this->asset, 'paths']),
            new \Twig_SimpleFunction('asset_download', [$this->asset, 'download']),
            new \Twig_SimpleFunction('asset_style', [$this->asset, 'style'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_styles', [$this->asset, 'styles'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_inline', [$this->asset, 'inline'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_script', [$this->asset, 'script'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('asset_scripts', [$this->asset, 'scripts'], ['is_safe' => ['html']])
        ];
    }

    /**
     * Get the filters.
     *
     * @return array
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('camel_case', [$this->str, 'camel']),
            new \Twig_SimpleFilter('snake_case', [$this->str, 'snake']),
            new \Twig_SimpleFilter('studly_case', [$this->str, 'studly']),
            new \Twig_SimpleFilter('humanize', [$this->str, 'humanize']),
            new \Twig_SimpleFilter(
                'str_*',
                function ($name) {

                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->str, camel_case($name)], $arguments);
                }
            ),
        ];
    }
}
