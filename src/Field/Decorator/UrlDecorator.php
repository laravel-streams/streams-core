<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Streams\Core\Field\FieldDecorator;
use Illuminate\Support\Facades\Request;

class UrlDecorator extends FieldDecorator
{

    /**
     * Return the parsed query string.
     *
     * @param  null $key
     * @param  null $default
     * @return mixed
     */
    public function query($key = null, $default = null)
    {
        if (!$parsed = $this->parsed()) {
            return null;
        }

        parse_str(Arr::get($parsed, 'query'), $query);

        if ($key) {
            return Arr::get($query, $key, $default);
        }

        return $query;
    }

    /**
     * Return the parsed URL.
     *
     * @param  null $key
     * @param  null $default
     * @return mixed
     */
    public function parsed($key = null, $default = null)
    {
        if ($url = $this->normalize()) {

            $parsed = parse_url($url);

            if ($key) {
                return Arr::get($parsed, $key, $default);
            }

            return $parsed;
        }

        return null;
    }

    /**
     * Return a link.
     *
     * @param  null $text
     * @return bool
     */
    public function link($title = null, $attributes = [])
    {
        if (!$url = $this->normalize()) {
            return null;
        }

        if (!$title) {
            $title = $url;
        }

        return HtmlFacade::link($url, $title, $attributes);
    }

    /**
     * Return the URL to the provided path.
     *
     * @param  null $path
     * @return null|string
     */
    public function to($path = null)
    {
        if (!$this->value) {
            return null;
        }

        $scheme = $this->parsed('scheme');
        $host   = $this->parsed('host');
        $port   = $this->parsed('port');

        $port = $port ? ':' . $port : null;
        $path = $path ? '/' . $path : null;

        return "{$scheme}://{$host}{$port}{$path}";
    }

    /**
     * Return a normalized URL.
     *
     * @return string|null
     */
    public function normalize()
    {
        if (!$value = $this->value) {
            return null;
        }

        /**
         * If the value is a route
         * then let's use that
         * first and foremost.
         */
        if (Route::has($value)) {
            return URL::route($value);
        }

        /**
         * If it's already a URL
         * then we're done here.
         */
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        /**
         * Otherwise try adding
         * a protocol and test that.
         */
        if (filter_var('http://' . $value, FILTER_VALIDATE_URL) && str_contains($value, '.')) {
            return (Request::isSecure() ? 'https://' : 'http://') . $value;
        }

        /**
         * Lastly try making it
         * a URL and test that.
         */
        if (filter_var(URL::to($value), FILTER_VALIDATE_URL)) {
            return URL::to($value);
        }

        return $value;
    }

    /**
     * Normalize the URL by default.
     *
     * @return bool|string
     */
    public function __toString()
    {
        return (string) $this->normalize() ?: '';
    }
}
