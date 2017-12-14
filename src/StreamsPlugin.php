<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Entry\Command\GetEntryCriteria;
use Anomaly\Streams\Platform\Image\Command\MakeImagePath;
use Anomaly\Streams\Platform\Image\Command\MakeImageTag;
use Anomaly\Streams\Platform\Image\Command\MakeImageUrl;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Model\Command\GetEloquentCriteria;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\Stream\Command\GetStream;
use Anomaly\Streams\Platform\Stream\Command\GetStreams;
use Anomaly\Streams\Platform\Support\Currency;
use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Support\Length;
use Anomaly\Streams\Platform\Support\Locale;
use Anomaly\Streams\Platform\Support\Markdown;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Support\Template;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Button\Command\GetButtons;
use Anomaly\Streams\Platform\Ui\Command\GetElapsedTime;
use Anomaly\Streams\Platform\Ui\Command\GetMemoryUsage;
use Anomaly\Streams\Platform\Ui\Command\GetTranslatedString;
use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;
use Anomaly\Streams\Platform\Ui\Icon\Command\GetIcon;
use Anomaly\Streams\Platform\View\Command\GetConstants;
use Anomaly\Streams\Platform\View\Command\GetLayoutName;
use Anomaly\Streams\Platform\View\Command\GetView;
use Carbon\Carbon;
use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Session\Store;
use Illuminate\Translation\Translator;
use Jenssegers\Agent\Agent;
use Symfony\Component\Yaml\Yaml;

/**
 * Class StreamsPlugin
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * The form HTML builder.
     *
     * @var FormBuilder
     */
    protected $form;

    /**
     * The base HTML builder.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * The YAML parser.
     *
     * @var Yaml
     */
    protected $yaml;

    /**
     * The agent utility.
     *
     * @var Agent
     */
    protected $agent;

    /**
     * The cache repository.
     *
     * @var CacheRepository
     */
    protected $cache;

    /**
     * The asset utility.
     *
     * @var Asset
     */
    protected $asset;

    /**
     * The config repository.
     *
     * @var ConfigRepository
     */
    protected $config;

    /**
     * The image utility.
     *
     * @var Image
     */
    protected $image;

    /**
     * The active route.
     *
     * @var Route
     */
    protected $route;

    /**
     * The router service.
     *
     * @var Router
     */
    protected $router;

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
     * The currency utility.
     *
     * @var Currency
     */
    protected $currency;

    /**
     * The template parser.
     *
     * @var Template
     */
    protected $template;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new AgentPlugin instance.
     *
     * @param UrlGenerator     $url
     * @param Str              $str
     * @param Guard            $auth
     * @param Yaml             $yaml
     * @param Agent            $agent
     * @param Asset            $asset
     * @param Image            $image
     * @param Router           $router
     * @param FormBuilder      $form
     * @param HtmlBuilder      $html
     * @param CacheRepository  $cache
     * @param ConfigRepository $config
     * @param Request          $request
     * @param Store            $session
     * @param Currency         $currency
     * @param Template         $template
     * @param Translator       $translator
     */
    public function __construct(
        UrlGenerator $url,
        Str $str,
        Guard $auth,
        Yaml $yaml,
        Agent $agent,
        Asset $asset,
        Image $image,
        Router $router,
        FormBuilder $form,
        HtmlBuilder $html,
        ConfigRepository $config,
        CacheRepository $cache,
        Request $request,
        Store $session,
        Currency $currency,
        Template $template,
        Translator $translator
    ) {
        $this->url        = $url;
        $this->str        = $str;
        $this->auth       = $auth;
        $this->form       = $form;
        $this->html       = $html;
        $this->yaml       = $yaml;
        $this->agent      = $agent;
        $this->asset      = $asset;
        $this->cache      = $cache;
        $this->image      = $image;
        $this->router     = $router;
        $this->config     = $config;
        $this->request    = $request;
        $this->session    = $session;
        $this->currency   = $currency;
        $this->template   = $template;
        $this->translator = $translator;

        $this->route = $request->route();
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
                'stream',
                function ($namespace, $slug = null) {
                    return (new Decorator())->decorate(
                        $this->dispatch(new GetStream($namespace, $slug ?: $namespace))
                    );
                }
            ),
            new \Twig_SimpleFunction(
                'streams',
                function ($namespace) {
                    return (new Decorator())->decorate(
                        $this->dispatch(new GetStreams($namespace))
                    );
                }
            ),
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
                'query',
                function ($model = null) {
                    return (new Decorator())->decorate(
                        $this->dispatch(new GetEloquentCriteria($model, 'get'))
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
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'img',
                function ($image) {
                    return $this->dispatch(new MakeImageTag($image));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'form',
                function () {
                    $arguments = func_get_args();

                    if (count($arguments) >= 2) {
                        $arguments = [
                            'namespace' => array_get(func_get_args(), 0),
                            'stream'    => array_get(func_get_args(), 1),
                            'entry'     => array_get(func_get_args(), 2),
                        ];
                    }

                    if (count($arguments) == 1) {
                        $arguments = func_get_arg(0);
                    }

                    return $this->dispatch(new GetFormCriteria($arguments));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'form_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->form, camel_case($name)], $arguments);
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'html_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->html, camel_case($name)], $arguments);
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'icon',
                function ($type, $class = null) {
                    return (new Decorator())->decorate($this->dispatch(new GetIcon($type, $class)));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'view',
                function ($view, array $data = []) {
                    return $this->dispatch(new GetView($view, $data))->render();
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'buttons',
                function ($buttons) {
                    return $this->dispatch(new GetButtons($buttons))->render();
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'constants',
                function () {
                    return $this->dispatch(new GetConstants())->render();
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new \Twig_SimpleFunction(
                'env',
                function ($key, $default = null) {
                    return env($key, $default);
                }
            ),
            new \Twig_SimpleFunction(
                'length',
                function ($length, $unit = null) {
                    return new Length($length, $unit);
                }
            ),
            new \Twig_SimpleFunction(
                'carbon',
                function ($time = null, $timezone = null) {
                    return new Carbon($time, $timezone);
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
                function ($key, array $parameters = [], $locale = null) {
                    return $this->dispatch(new GetTranslatedString($key, $parameters, $locale));
                }
            ),
            new \Twig_SimpleFunction(
                'locale',
                function ($locale = null) {
                    return (new Locale($locale));
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
                'route_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->route, camel_case($name)], $arguments);
                }
            ),
            new \Twig_SimpleFunction(
                'asset_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->asset, camel_case($name)], $arguments);
                }, ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'currency_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->currency, camel_case($name)], $arguments);
                }
            ),
            new \Twig_SimpleFunction(
                'yaml',
                function ($input) {

                    if ($input instanceof FieldTypePresenter) {
                        $input = $input->__toString();
                    }

                    return $this->yaml->parse($input);
                }
            ),
            new \Twig_SimpleFunction(
                'addon',
                function ($identifier) {
                    return (new Decorator())->decorate(app(AddonCollection::class)->get($identifier));
                }
            ),
            new \Twig_SimpleFunction(
                'addons',
                function ($type = null) {
                    $addons = app(AddonCollection::class);

                    if ($type) {
                        $addons = $addons->{str_plural($type)}();
                    }

                    return (new Decorator())->decorate($addons);
                }
            ),
            new \Twig_SimpleFunction(
                'breadcrumb',
                function () {
                    return app(BreadcrumbCollection::class);
                }, ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'favicons',
                function ($source) {
                    return view('streams::partials.favicons', compact('source'));
                }, ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'gravatar',
                function ($email, array $parameters = []) {
                    return $this->image->make(
                        'https://www.gravatar.com/avatar/' . md5($email) . '?' . http_build_query(
                            $parameters
                        ),
                        'image'
                    );
                }, ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFunction(
                'cookie',
                function ($key, $default = null) {
                    return array_get($_COOKIE, $key, $default);
                }
            ),
            new \Twig_SimpleFunction('input_get', [$this->request, 'input']),
            new \Twig_SimpleFunction('asset', [$this->url, 'asset'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('action', [$this->url, 'action'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('url', [$this, 'url'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('route', [$this->url, 'route'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('route_has', [$this->router, 'has'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('secure_url', [$this->url, 'secure'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('secure_asset', [$this->url, 'secureAsset'], ['is_safe' => ['html']]),
            new \Twig_SimpleFunction('config', [$this->config, 'get']),
            new \Twig_SimpleFunction('config_get', [$this->config, 'get']),
            new \Twig_SimpleFunction('config_has', [$this->config, 'has']),
            new \Twig_SimpleFunction('cache', [$this->cache, 'get']),
            new \Twig_SimpleFunction('cache_get', [$this->cache, 'get']),
            new \Twig_SimpleFunction('cache_has', [$this->cache, 'has']),
            new \Twig_SimpleFunction('auth_user', [$this->auth, 'user']),
            new \Twig_SimpleFunction('auth_check', [$this->auth, 'check']),
            new \Twig_SimpleFunction('auth_guest', [$this->auth, 'guest']),
            new \Twig_SimpleFunction('trans_exists', [$this->translator, 'exists']),
            new \Twig_SimpleFunction('trans_choice', [$this->translator, 'choice']),
            new \Twig_SimpleFunction('message_get', [$this->session, 'pull']),
            new \Twig_SimpleFunction('message_exists', [$this->session, 'has']),
            new \Twig_SimpleFunction('session', [$this->session, 'get']),
            new \Twig_SimpleFunction('parse', [$this->template, 'render']),
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
                'markdown',
                function ($content) {
                    return (new Markdown())->parse($content);
                },
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFilter(
                'str_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);

                    return call_user_func_array([$this->str, camel_case($name)], $arguments);
                }
            ),
        ];
    }

    /**
     * Returns a list of global variables
     * to add to the existing variables.
     *
     * @return array
     */
    public function getGlobals()
    {
        return [
            'app' => app(),
        ];
    }

    /**
     * Return a URL.
     *
     * @param  null  $path
     * @param  array $parameters
     * @param  null  $secure
     * @return string
     */
    public function url($path = null, $parameters = [], $secure = null)
    {
        return $this->url->to($path, $parameters, $secure);
    }
}
