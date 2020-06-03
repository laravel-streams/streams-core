<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Support\Value;
use Anomaly\Streams\Platform\Image\ImageManager;
use Anomaly\Streams\Platform\Asset\Facades\Assets;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Message\Facades\Messages;
use Anomaly\Streams\Platform\Support\Facades\Decorator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;
use Anomaly\Streams\Platform\Ui\Form\Command\GetTableCriteria;

if (!function_exists('app_storage_path')) {

    /**
     * Get the storage path for the application.
     *
     * @param  string $path
     * @return string
     */
    function app_storage_path($path = '')
    {
        /* @var Application $application */
        $application = app(Application::class);

        return storage_path('streams/' . $application->getReference()) . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('app_resources_path')) {

    /**
     * Get the storage path for the application.
     *
     * @param  string $path
     * @return string
     */
    function app_resources_path($path = '')
    {
        /* @var Application $application */
        $application = app(Application::class);

        return $application->getResourcesPath($path ? '/' . $path : $path);
    }
}

if (!function_exists('array_value')) {

    /**
     * Get the literal key value of an array
     * without any of the funny business.
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed
     */
    function array_value($array, $key, $default = null)
    {
        if (isset($array[$key]) || array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}

if (!function_exists('str_humanize')) {

    /**
     * Humanize the string.
     *
     * @param        $target
     * @param string $separator
     * @return string
     */
    function str_humanize($target, $separator = '_')
    {
        return Str::humanize($target, $separator);
    }
}

if (!function_exists('valuate')) {

    /**
     * Make a valuation.
     *
     * @param        $parameters
     * @param        $entry
     * @param string $term
     * @param array $payload
     * @return mixed
     */
    function valuate($parameters, $entry, $term = 'entry', $payload = [])
    {
        return Value::make($parameters, $entry, $term, $payload);
    }
}

if (!function_exists('data')) {

    /**
     * Get an item from an array or object using "dot" notation.
     *
     * @param  mixed $target
     * @param  string|array $key
     * @param  mixed $default
     * @return mixed
     */
    function data($target, $key, $default = null)
    {
        if (is_null($key)) {
            return $target;
        }

        $key = is_array($key) ? $key : explode('.', $key);

        while (!is_null($segment = array_shift($key))) {
            if ($segment === '*') {
                if ($target instanceof Collection) {
                    $target = $target->all();
                } elseif (!is_array($target)) {
                    return value($default);
                }

                $result = Arr::pluck($target, $key);

                return in_array('*', $key) ? Arr::collapse($result) : $result;
            }

            if (Arr::accessible($target) && Arr::exists($target, $segment)) {
                $target = $target[$segment];
            } elseif (is_object($target) && isset($target->{$segment})) {
                $target = $target->{$segment};
            } elseif (is_object($target) && method_exists($target, $segment)) {
                // This is different than laravel..
                $target = call_user_func([$target, $segment]);
            } else {
                return value($default);
            }
        }

        return $target;
    }
}

if (!function_exists('filesize_for_humans')) {

    /**
     * Humanize the filesize
     *
     * @param      integer $bytes    The bytes
     * @param      integer $decimals The decimals
     * @return     string
     */
    function filesize_for_humans($bytes, $decimals = 2)
    {
        $size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $factor = (int) floor((strlen($bytes) - 1) / 3);

        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . '&nbsp;' . @$size[$factor];
    }
}

if (!function_exists('console')) {

    /**
     * Return the console instance.
     *
     * @return \Anomaly\Streams\Platform\Console\Kernel
     */
    function console()
    {
        return app(\Illuminate\Contracts\Console\Kernel::class);
    }
}

if (!function_exists('cp')) {

    /**
     * Return the control panel builder instance.
     *
     * @return \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder
     */
    function cp()
    {
        return Decorator::decorate(app(\Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder::class)->getControlPanel());
    }
}

if (!function_exists('form')) {

    /**
     * Return a form criteria.
     *
     * @return \Anomaly\Streams\Platform\Ui\Form\FormCriteria|\Anomaly\Streams\Platform\Ui\Form\FormBuilder
     */
    function form()
    {
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

        return decorate(dispatch_now(new GetFormCriteria($arguments)));
    }
}

if (!function_exists('table')) {

    /**
     * Return a table criteria.
     *
     * @return \Anomaly\Streams\Platform\Ui\Table\TableCriteria|\Anomaly\Streams\Platform\Ui\Table\TableBuilder
     */
    function table()
    {
        $arguments = func_get_args();

        if (count($arguments) >= 2) {
            $arguments = [
                'namespace' => array_get(func_get_args(), 0),
                'stream'    => array_get(func_get_args(), 1),
            ];
        }

        if (count($arguments) == 1) {
            $arguments = func_get_arg(0);
        }

        return decorate(dispatch_now(new GetTableCriteria($arguments)));
    }
}

if (!function_exists('buttons')) {

    /**
     * Return button HTML.
     * 
     * @todo REMOVE this crap and all things like it. It's a view in a function? Used in a view? Wtf Ryan.. 
     *
     * @param \Illuminate\Support\Collection $buttons
     * @return \Illuminate\View\View
     */
    function buttons(Collection $buttons)
    {
        return view('streams::ui/buttons/buttons', ['buttons' => $buttons->values()]);
    }
}

if (!function_exists('html_attributes')) {

    /**
     * Return an HTML attribute string.
     *
     * @param array $attributes
     * @return string
     */
    function html_attributes(array $attributes = [])
    {
        return app('html')->attributes($attributes);
    }
}

if (!function_exists('messages')) {

    /**
     * Shortcut message bag functionality.
     *
     * @param null $type
     * @param null $message
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    function messages($type = null, $message = null)
    {
        if ($type && !$message) {
            return Messages::get($type);
        }

        if ($type && $message) {
            return Messages::add($type, $message);
        }

        return app('messages');
    }
}

if (!function_exists('assets')) {

    /**
     * Add an asset to a collection or instance.
     *
     * @param null $collection
     * @param null $asset
     * @return \Anomaly\Streams\Platform\Asset\Asset
     */
    function assets($collection = null, $asset = null)
    {
        if ($collection && $asset) {
            return Assets::collection($collection)->add($asset);
        }

        if ($collection) {
            return Assets::collection($collection);
        }

        return app('assets');
    }
}

if (!function_exists('img')) {

    /**
     * Return an image instance.
     *
     * @param mixed $source
     * @return \Anomaly\Streams\Platform\Image\ImageManager
     */
    function img($source = null)
    {
        if (!$source) {
            return app(ImageManager::class);
        }

        return app(ImageManager::class)->make($source);
    }
}

if (!function_exists('decorate')) {

    /**
     * Decorate a target
     *
     * @param null $collection
     * @param null $asset
     * @param array $filters
     * @return \Anomaly\Streams\Platform\Support\Presenter
     */
    function decorate($target)
    {
        return app(\Anomaly\Streams\Platform\Support\Decorator::class)->decorate($target);
    }
}

if (!function_exists('undecorate')) {

    /**
     * Un-decorate a target
     *
     * @return mixed
     */
    function undecorate($target)
    {
        return app(\Anomaly\Streams\Platform\Support\Facades\Decorator::class)->undecorate($target);
    }
}

if (!function_exists('application')) {

    /**
     * Return the active user or null.
     *
     * @return \Anomaly\Streams\Platform\Application\Application
     */
    function application()
    {
        return app(\Anomaly\Streams\Platform\Application\Application::class);
    }
}

if (!function_exists('elapsed_time')) {

    /**
     * Return the elapsed application time.
     *
     * @return float
     */
    function elapsed_time($decimals = 3, $since = null)
    {
        $since = $since ?: request()->server('REQUEST_TIME_FLOAT');

        return number_format(microtime(true) - $since, $decimals);
    }
}

if (!function_exists('favicons')) {

    /**
     * Return favicons from a single source.
     *
     * @param $source
     * @return \Illuminate\View\View
     */
    function favicons($source)
    {
        return view('streams::partials.favicons', compact('source'));
    }
}

if (!function_exists('constants')) {

    /**
     * Return required JS constants.
     * 
     * @todo this should probably be moved into core/streams-platform instead of streams::
     * @return \Illuminate\View\View
     */
    function constants()
    {
        return view('streams::partials.constants');
    }
}

if (!function_exists('markdown')) {

    /**
     * Return parsed markdown content.
     * 
     * @return string
     */
    function markdown($content)
    {
        return (new ParsedownExtra())->parse($content);
    }
}

if (!function_exists('entries')) {

    /**
     * Return a collection of entries.
     * 
     * @return \Anomaly\Streams\Platform\Entry\EntryQueryBuilder
     */
    function entries(string $namespace, string $stream = null)
    {
        return stream($namespace, $stream)->model->newQuery();
    }
}

if (!function_exists('stream')) {

    /**
     * Return a single stream.
     * 
     * @return StreamInterface
     */
    function stream(string $namespace, string $stream = null)
    {
        return decorate(app($namespace . '.' . $stream));
    }
}

if (!function_exists('streams')) {

    /**
     * Return a collection of streams.
     * 
     * @return string
     */
    function streams(string $namespace)
    {
        return app(\Anomaly\Streams\Platform\Stream\StreamManager::class);
    }
}

if (!function_exists('form_open')) {

    /**
     * Render a form opening.
     *
     * @param array $options
     * 
     * @return \Illuminate\Support\HtmlString
     */
    function form_open(array $options = [])
    {
        return \Form::open($options);
    }
}

if (!function_exists('form_close')) {

    /**
     * Render a form opening.
     * 
     * @return \Illuminate\Support\HtmlString
     */
    function form_close()
    {
        return \Form::close();
    }
}

if (!function_exists('html_link')) {

    /**
     * Generate a HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    function html_link($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        return \Html::link($url, $title, $attributes, $secure, $escape);
    }
}

if (!function_exists('addon_map')) {

    /**
     * Return the variable map
     * for an addon namespace.
     *
     * @param string $namespace
     * @param bool $verify
     *
     * @return array
     */
    function addon_map($namespace, $verify = true)
    {
        [$vendor, $type, $slug] = array_map(
            function ($value) {
                return str_slug(strtolower($value), '_');
            },
            explode('.', $namespace)
        );

        if ($verify && preg_match('/^\w+\.[a-zA-Z_]+\.\w+\z/u', $namespace) !== 1) {
            throw new \Exception('Addon identifiers must be snake case and follow the following pattern: {vendor}.{type}.{slug}');
        }

        return [$vendor, $type, $slug];
    }
}

if (!function_exists('translate')) {

    /**
     * Return a recursively translated target.
     *
     * @param mixed $target
     * @return mixed
     */
    function translate($target)
    {
        if (is_string($target) && strpos($target, '::')) {

            if (!trans()->has($target)) {
                return $target;
            }

            return trans($target);
        }

        if (is_array($target)) {
            foreach ($target as &$item) {
                $item = translate($item);
            }
        }

        if ($target instanceof Collection) {
            foreach ($target as &$item) {
                $item = translate($item);
            }
        }

        return $target;
    }
}

if (!function_exists('resolver')) {

    /**
     * Resolve the target.
     *
     * @param $target
     * @param array $arguments
     * @param array $options
     * @return mixed
     */
    function resolver($target, array $arguments = [], array $options = [])
    {
        return \Anomaly\Streams\Platform\Support\Facades\Resolver::resolve($target, $arguments, $options);
    }
}

if (!function_exists('evaluate')) {

    /**
     * Resolve the target.
     *
     * @param $target
     * @param array $arguments
     * @return mixed
     */
    function evaluate($target, array $arguments = [])
    {
        return \Anomaly\Streams\Platform\Support\Facades\Evaluator::evaluate($target, $arguments);
    }
}

if (!function_exists('icon')) {

    /**
     * Return an icon.
     *
     * @param $icon
     * @return string
     */
    function icon($icon)
    {
        return '<i class="' . app(\Anomaly\Streams\Platform\Ui\Icon\IconRegistry::class)->get($icon) . '"></i>';
    }
}

if (!function_exists('addon')) {

    /**
     * Return an addon instance.
     *
     * @param  string $identifier
     * @return \Anomaly\Streams\Platform\Addon\Addon|null
     */
    function addon($identifier)
    {
        try {
            app($identifier);
        } catch (\Exception $exception) {
            return null;
        }
    }
}
