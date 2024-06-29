<?php namespace Anomaly\Streams\Platform;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Entry\Command\GetEntryCriteria;
use Anomaly\Streams\Platform\Image\Command\MakeImageInstance;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Model\Command\GetEloquentCriteria;
use Anomaly\Streams\Platform\Stream\Command\GetStream;
use Anomaly\Streams\Platform\Stream\Command\GetStreams;
use Anomaly\Streams\Platform\Support\Currency;
use Anomaly\Streams\Platform\Support\Decorator;
use Anomaly\Streams\Platform\Support\Length;
use Anomaly\Streams\Platform\Support\Locale;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Support\Template;
use Anomaly\Streams\Platform\Support\Value;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Button\Command\GetButtons;
use Anomaly\Streams\Platform\Ui\Command\GetElapsedTime;
use Anomaly\Streams\Platform\Ui\Command\GetMemoryUsage;
use Anomaly\Streams\Platform\Ui\Command\GetTranslatedString;
use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;
use Anomaly\Streams\Platform\Ui\Table\Command\GetTableCriteria;
use Anomaly\Streams\Platform\Ui\Icon\Command\GetIcon;
use Anomaly\Streams\Platform\View\Command\GetConstants;
use Anomaly\Streams\Platform\View\Command\GetLayoutName;
use Anomaly\Streams\Platform\View\Command\GetView;
use Anomaly\Streams\Platform\View\Support\CompressHtmlTokenParser;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Jenssegers\Agent\Agent;
use Symfony\Component\Yaml\Yaml;
use Twig\TwigFilter;
use Twig\TwigFunction;

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
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'stream',
                function ($namespace, $slug = null) {
                    return (new Decorator())->decorate(
                        dispatch_sync(new GetStream($namespace, $slug ?: $namespace))
                    );
                }
            ),
            new TwigFunction(
                'streams',
                function ($namespace) {
                    return (new Decorator())->decorate(
                        dispatch_sync(new GetStreams($namespace))
                    );
                }
            ),
            new TwigFunction(
                'entry',
                function ($namespace, $stream = null) {
                    return (new Decorator())->decorate(
                        dispatch_sync(new GetEntryCriteria($namespace, $stream ?: $namespace, 'first'))
                    );
                }
            ),
            new TwigFunction(
                'entries',
                function ($namespace, $stream = null) {
                    return (new Decorator())->decorate(
                        dispatch_sync(new GetEntryCriteria($namespace, $stream ?: $namespace, 'get'))
                    );
                }
            ),
            new TwigFunction(
                'query',
                function ($model = null) {
                    return (new Decorator())->decorate(
                        dispatch_sync(new GetEloquentCriteria($model, 'get'))
                    );
                }
            ),
            new TwigFunction(
                'img',
                function ($image) {
                    return dispatch_sync(new MakeImageInstance($image, 'img'));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'table',
                function () {
                    $arguments = func_get_args();

                    if (count($arguments) >= 2) {
                        $arguments = [
                            'namespace' => Arr::get(func_get_args(), 0),
                            'stream'    => Arr::get(func_get_args(), 1),
                        ];
                    }

                    if (count($arguments) == 1) {
                        $arguments = func_get_arg(0);
                    }

                    return dispatch_sync(new GetTableCriteria($arguments));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'form',
                function () {
                    $arguments = func_get_args();

                    if (count($arguments) >= 2) {
                        $arguments = [
                            'namespace' => Arr::get(func_get_args(), 0),
                            'stream'    => Arr::get(func_get_args(), 1),
                            'entry'     => Arr::get(func_get_args(), 2),
                        ];
                    }

                    if (count($arguments) == 1) {
                        $arguments = func_get_arg(0);
                    }

                    return dispatch_sync(new GetFormCriteria($arguments));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'form_*',
                function ($name) {
                    return call_user_func_array([app('form'), camel_case($name)], array_slice(func_get_args(), 1));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'html_*',
                function ($name) {
                    return call_user_func_array([app('html'), camel_case($name)], array_slice(func_get_args(), 1));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'array_*',
                function ($name) {
                    return call_user_func_array([app(Arr::class), camel_case($name)], array_slice(func_get_args(), 1));
                }
            ),
            new TwigFunction(
                'icon',
                function ($type, $class = null) {
                    return (new Decorator())->decorate(dispatch_sync(new GetIcon($type, $class)));
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'view',
                function ($view, array $data = []) {
                    return dispatch_sync(new GetView($view, $data))->render();
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'template',
                function ($key = null, $default = null) {

                    /* @var ViewTemplate $template */
                    $template = app(ViewTemplate::class);

                    if (!$key) {
                        return $template;
                    }

                    return $template->get($key, $default);
                }
            ),
            new TwigFunction(
                'buttons',
                function ($buttons) {
                    return dispatch_sync(new GetButtons($buttons))->render();
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'constants',
                function () {
                    return dispatch_sync(new GetConstants())->render();
                },
                [
                    'is_safe' => ['html'],
                ]
            ),
            new TwigFunction(
                'env',
                function ($key, $default = null) {
                    return env($key, $default);
                }
            ),
            new TwigFunction(
                'length',
                function ($length, $unit = null) {
                    return new Length($length, $unit);
                }
            ),
            new TwigFunction(
                'carbon',
                function ($time = null, $timezone = null) {
                    return new Carbon($time, $timezone);
                }
            ),
            new TwigFunction(
                'decorate',
                function ($value) {
                    return (new Decorator())->decorate($value);
                }
            ),
            new TwigFunction(
                'request_time',
                function ($decimal = 2) {
                    return dispatch_sync(new GetElapsedTime($decimal));
                }
            ),
            new TwigFunction(
                'memory_usage',
                function ($precision = 1) {
                    return dispatch_sync(new GetMemoryUsage($precision));
                }
            ),
            new TwigFunction(
                'layout',
                function ($layout, $default = 'default') {
                    return dispatch_sync(new GetLayoutName($layout, $default));
                }
            ),
            new TwigFunction(
                'request',
                function () {
                    return request(func_get_args() ?: null);
                }
            ),
            new TwigFunction(
                'request_*',
                function ($name) {
                    return call_user_func_array([request(), camel_case($name)], array_slice(func_get_args(), 1));
                }
            ),
            new TwigFunction(
                'trans',
                function ($key, array $parameters = [], $locale = null) {
                    return dispatch_sync(new GetTranslatedString($key, $parameters, $locale));
                }
            ),
            new TwigFunction(
                'locale',
                function ($locale = null) {
                    return (new Locale($locale));
                }
            ),
            new TwigFunction(
                'str_*',
                function ($name) {
                    return call_user_func_array(
                        [app(Str::class), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'url_*',
                function ($name) {
                    return call_user_func_array(
                        [url(), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'route_*',
                function ($name) {
                    return call_user_func_array(
                        [request()->route(), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'asset_*',
                function ($name) {
                    return call_user_func_array(
                        [app(Asset::class), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'currency_*',
                function ($name) {
                    return call_user_func_array(
                        [app(Currency::class), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'value',
                function () {
                    return call_user_func_array(
                        [app(Value::class), 'make'],
                        func_get_args()
                    );
                }
            ),
            new TwigFunction(
                'yaml',
                function ($input) {

                    if ($input instanceof FieldTypePresenter) {
                        $input = $input->__toString();
                    }

                    return app(Yaml::class)->parse($input);
                }
            ),
            new TwigFunction(
                'addon',
                function ($identifier) {
                    return (new Decorator())->decorate(app(AddonCollection::class)->get($identifier));
                }
            ),
            new TwigFunction(
                'addons',
                function ($type = null) {

                    $addons = app(AddonCollection::class);

                    if ($type) {
                        $addons = $addons->{str_plural($type)}();
                    }

                    return (new Decorator())->decorate($addons);
                }
            ),
            new TwigFunction(
                'breadcrumb',
                function () {
                    return app(BreadcrumbCollection::class);
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'favicons',
                function ($source) {
                    return view('streams::partials.favicons', compact('source'));
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'gravatar',
                function ($email, array $parameters = []) {
                    return app(Image::class)->make(
                        'https://www.gravatar.com/avatar/' . md5($email) . '?' . http_build_query(
                            $parameters
                        ),
                        'image'
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'cookie',
                function ($key, $default = null) {
                    return Arr::get($_COOKIE, $key, $default);
                }
            ),
            new TwigFunction(
                'csrf_*',
                function ($name) {

                    if (!in_array($name, ['token', 'field'])) {
                        throw new \Exception('Function [csrf_' . $name . '] does not exist.');
                    }

                    $helper = 'csrf_' . $name;

                    return call_user_func(
                        $helper,
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'input_get',
                function () {
                    return call_user_func_array(
                        [request(), 'input'],
                        func_get_args()
                    );
                }
            ),
            new TwigFunction(
                'asset',
                function () {
                    return call_user_func_array(
                        [url(), 'asset'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'action',
                function () {
                    return call_user_func_array(
                        [url(), 'action'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'url',
                function () {

                    if (!func_get_args()) {
                        return url()->current();
                    }

                    return call_user_func_array(
                        [url(), 'to'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'route',
                function () {
                    return call_user_func_array(
                        [url(), 'route'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'route_has',
                function () {
                    return call_user_func_array(
                        [request()->route(), 'has'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'secure_url',
                function () {
                    return call_user_func_array(
                        [url(), 'secure'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'secure_asset',
                function () {
                    return call_user_func_array(
                        [url(), 'secureAsset'],
                        func_get_args()
                    );
                }, ['is_safe' => ['html']]
            ),
            new TwigFunction(
                'config',
                function () {
                    return call_user_func_array(
                        [config(), 'get'],
                        func_get_args()
                    );
                }
            ),
            new TwigFunction(
                'config_*',
                function ($name) {

                    if (!in_array($name, ['get', 'has'])) {
                        throw new \Exception('Function [config_' . $name . '] does not exist.');
                    }

                    return call_user_func_array(
                        [config(), $name],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'cache',
                function () {
                    return call_user_func_array(
                        [cache(), 'get'],
                        func_get_args()
                    );
                }
            ),
            new TwigFunction(
                'cache_*',
                function ($name) {

                    if (!in_array($name, ['get', 'has'])) {
                        throw new \Exception('Function [cache_' . $name . '] does not exist.');
                    }

                    return call_user_func_array(
                        [cache(), $name],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'auth_*',
                function ($name) {

                    if (!in_array($name, ['user', 'check', 'guest'])) {
                        throw new \Exception('Function [auth_' . $name . '] does not exist.');
                    }

                    return call_user_func_array(
                        [auth(), $name],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'trans_*',
                function ($name) {

                    if (!in_array($name, ['has', 'exists', 'choice'])) {
                        throw new \Exception('Function [trans_' . $name . '] does not exist.');
                    }

                    if ($name == 'exists') {
                        $name = 'has';
                    }

                    return call_user_func_array(
                        [trans(), $name],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'message_*',
                function ($name) {

                    if (!in_array($name, ['pull', 'get', 'has', 'exists'])) {
                        throw new \Exception('Function [message_' . $name . '] does not exist.');
                    }

                    if ($name == 'exists') {
                        $name = 'has';
                    }

                    return call_user_func_array(
                        [app(MessageBag::class), $name],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'session',
                function () {
                    return call_user_func_array(
                        [session(), 'get'],
                        func_get_args()
                    );
                }
            ),
            new TwigFunction(
                'parse',
                function () {
                    return call_user_func_array(
                        [app(Template::class), 'render'],
                        func_get_args()
                    );
                }
            ),
            new TwigFunction(
                'session_*',
                function ($name) {

                    if (!in_array($name, ['get', 'pull', 'has'])) {
                        throw new \Exception('Function [session_' . $name . '] does not exist.');
                    }

                    return call_user_func_array(
                        [session(), $name],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'agent_*',
                function ($name) {

                    if (!in_array(
                        $name,
                        [
                            'device',
                            'browser',
                            'version',
                            'platform',
                            'is_phone',
                            'is_robot',
                            'is_tablet',
                            'is_mobile',
                            'is_desktop',
                        ]
                    )
                    ) {
                        throw new \Exception('Function [agent_' . $name . '] does not exist.');
                    }

                    return call_user_func_array(
                        [app(Agent::class), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
            new TwigFunction(
                'app',
                function () {
                    return call_user_func_array(
                        ['app'],
                        func_get_args()
                    );
                }
            ),
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
            new TwigFilter(
                'camel_case',
                function () {
                    return call_user_func_array(
                        [app(Str::class), 'camel'],
                        func_get_args()
                    );
                }
            ),
            new TwigFilter(
                'snake_case',
                function () {
                    return call_user_func_array(
                        [app(Str::class), 'snake'],
                        func_get_args()
                    );
                }
            ),
            new TwigFilter(
                'studly_case',
                function () {
                    return call_user_func_array(
                        [app(Str::class), 'studly'],
                        func_get_args()
                    );
                }
            ),
            new TwigFilter(
                'humanize',
                function () {
                    return call_user_func_array(
                        [app(Str::class), 'humanize'],
                        func_get_args()
                    );
                }
            ),
            new TwigFilter(
                'parse',
                function () {
                    return call_user_func_array(
                        [app(Template::class), 'render'],
                        func_get_args()
                    );
                }
            ),
            new TwigFilter(
                'str_*',
                function ($name) {
                    return call_user_func_array(
                        [app(Str::class), camel_case($name)],
                        array_slice(func_get_args(), 1)
                    );
                }
            ),
        ];
    }

    /**
     * Get token parsers.
     *
     * @return array
     */
    public function getTokenParsers()
    {
        return [
            new CompressHtmlTokenParser(),
        ];
    }

    /**
     * Return a URL.
     *
     * @param  null $path
     * @param  array $parameters
     * @param  null $secure
     * @return string
     */
    public function url($path = null, $parameters = [], $secure = null)
    {
        return url()->to($path, $parameters, $secure);
    }
}
