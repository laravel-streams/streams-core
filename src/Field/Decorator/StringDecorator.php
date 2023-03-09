<?php

namespace Streams\Core\Field\Decorator;

use Illuminate\Support\Str;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\View;
use Streams\Core\Field\FieldDecorator;
use Symfony\Component\Yaml\Yaml;

class StringDecorator extends FieldDecorator
{
    public function yaml(int $flags = 0)
    {
        return Yaml::parse($this->value, $flags);
    }
    
    public function markdown(): string
    {
        return Str::markdown($this->value);
    }

    public function parse(array $data = []): string
    {
        return Str::parse($this->value, $data);
    }
    
    public function render(array $data = []): string
    {
        return View::parse($this->value, $data)->render();
    }

    public function lines($separator = "\n", ?int $limit = 9999): array
    {
        return explode($separator, $this->value, $limit);
    }

    public function decode(bool $associative = false, int $depth = 512, int $flags = 0): array|object|null
    {
        return json_decode($this->value, $associative, $depth, $flags);
    }

    public function unserialize(array $options = []): array|object|null
    {
        return unserialize($this->value, $options);
    }

    public function tel($text = null, array $attributes = []): string|null
    {
        if (!$this->value) {
            return null;
        }

        return HtmlFacade::link(
            'tel:' . preg_replace('/[^\+\d]/', '', $this->value),
            $text ?: $this->value,
            $attributes
        );
    }

    public function sms($text = null, array $attributes = []): string|null
    {
        if (!$this->value) {
            return null;
        }

        return HtmlFacade::link(
            'sms:' . preg_replace('/[^\+\d]/', '', $this->value),
            $text ?: $this->value,
            $attributes
        );
    }

    public function __call($method, $arguments)
    {
        return Str::{$method}($this->value, ...$arguments);
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}
