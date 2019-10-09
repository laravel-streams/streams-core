<?php

use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Asset\Asset;
use Anomaly\Streams\Platform\Image\Image;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Support\Value;
use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Support\Markdown;
use Anomaly\Streams\Platform\Support\Template;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\Command\GetButtons;
use Anomaly\Streams\Platform\Ui\Form\Command\GetFormCriteria;

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
        return app(Str::class)->humanize($target, $separator);
    }
}

if (!function_exists('humanize')) {

    /**
     * Humanize the string.
     *
     * @param        $target
     * @param string $separator
     * @return string
     */
    function humanize($target, $separator = '_')
    {
        return app(Str::class)->humanize($target, $separator);
    }
}

if (!function_exists('parse')) {

    /**
     * Parse the target with data.
     *
     * @param       $target
     * @param array $data
     * @return mixed    The parsed target.
     */
    function parse($target, array $data = [])
    {
        return app(Parser::class)->parse($target, $data);
    }
}

if (!function_exists('render')) {

    /**
     * Render the string template.
     *
     * @param       $template
     * @param array $payload
     * @return string
     */
    function render($template, array $payload = [])
    {
        return app(Template::class)->render($template, $payload);
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
        return app(Value::class)->make($parameters, $entry, $term, $payload);
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

if (!function_exists('template')) {

    /**
     * Template data helper function.
     *
     * @return \Anomaly\Streams\Platform\View\ViewTemplate
     */
    function template()
    {
        $arguments = func_get_args();

        /* @var ViewTemplate $template */
        $template = app(ViewTemplate::class);

        if (empty($arguments)) {
            return $template;
        }

        if (is_string($arguments[0])) {
            return $template->get(...$arguments);
        }

        if (!is_array($arguments[0])) {
            throw new Exception(
                'When setting a value in the template data, you must pass an array of key / value pairs.'
            );
        }

        return $template->set(key($arguments[0]), reset($arguments[0]));
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
        return app(\Anomaly\Streams\Platform\Console\Kernel::class);
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

        return dispatch_now(new GetFormCriteria($arguments));
    }
}

if (!function_exists('buttons')) {

    /**
     * Return button HTML.
     *
     * @param \Anomaly\Streams\Platform\Ui\Button\ButtonCollection $buttons
     * @return \Illuminate\View\View
     */
    function buttons(ButtonCollection $buttons)
    {
        return dispatch_now(new GetButtons($buttons));
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
        if (!$type && !$message) {
            return app(MessageBag::class);
        }

        if ($type && !$message) {
            return app(MessageBag::class)->get($type);
        }

        if ($type && $message) {
            return app(MessageBag::class)->add($type, $message);
        }

        return app(MessageBag::class);
    }
}

if (!function_exists('assets')) {

    /**
     * Add an asset to a collection or instance.
     *
     * @param null $collection
     * @param null $asset
     * @param array $filters
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    function assets($collection = null, $asset = null, array $filters = [])
    {
        if ($collection && $asset) {
            return app(Asset::class)->add($collection, $asset, $filters);
        }

        return app(Asset::class);
    }
}

if (!function_exists('img')) {

    /**
     * Return an image instance.
     *
     * @return \Anomaly\Streams\Platform\Image\Image
     */
    function img($source)
    {
        return app(Image::class)->make($source);
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
        return app(\Anomaly\Streams\Platform\Support\Decorator::class)->undecorate($target);
    }
}

if (!function_exists('share')) {

    /**
     * Share data with the view system.
     *
     * @param $key
     * @param $value
     * @param bool $global
     * @return ViewTemplate
     */
    function share($key, $value, $global = false)
    {
        if (!$global) {
            return app(ViewTemplate::class)->set($key, $value);
        }

        \View::share($key, $value);

        // @todo revisit and fix this - test.
        return app(Anomaly\Streams\Platform\View\Twig\Engine::class)->global($key, $value);
    }
}

if (!function_exists('user')) {

    /**
     * Return the active user or null.
     *
     * @return \Anomaly\Streams\Platform\User\Contract\UserInterface
     */
    function user()
    {
        return auth()->user();
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
        return (new Markdown())->parse($content);
    }
}
