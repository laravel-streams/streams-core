<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Arr;
use Collective\Html\HtmlFacade;
use Streams\Core\Field\FieldDecorator;

class UrlDecorator extends FieldDecorator
{
    public function parse($key = null, $default = null)
    {
        if (!$this->value) {
            return null;
        }

        $parsed = parse_url($this->value);

        if ($key) {
            return Arr::get($parsed, $key, $default);
        }

        return $parsed;
    }

    public function query($key = null, $default = null)
    {
        if (!$parsed = $this->parse()) {
            return null;
        }

        parse_str(Arr::get($parsed, 'query'), $query);

        if ($key) {
            return Arr::get($query, $key, $default);
        }

        return $query;
    }

    public function link($title = null, $attributes = []): string|null
    {
        if (!$this->value) {
            return null;
        }

        if (!$title) {
            $title = $this->value;
        }

        return HtmlFacade::link($this->value, $title, $attributes);
    }

    public function to(string $path = null): string|null
    {
        if (!$this->value) {
            return null;
        }

        $parsed = $this->parse();

        $scheme = Arr::get($parsed, 'scheme');
        $host   = Arr::get($parsed, 'host');
        $port   = Arr::get($parsed, 'port');

        $port = $port ? ':' . $port : null;
        $path = $path ? '/' . $path : null;

        return "{$scheme}://{$host}{$port}{$path}";
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
