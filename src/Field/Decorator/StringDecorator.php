<?php

namespace Streams\Core\Field\Decorator;

use Collective\Html\HtmlFacade;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Streams\Core\Field\FieldDecorator;

class StringDecorator extends FieldDecorator
{

    public function lines($separator = "\n", ?int $limit = null)
    {
        return explode($separator, $this->value, $limit);
    }

    public function json(bool $associative = false, int $depth = 512, int $flags = 0)
    {
        return json_decode($this->value, $associative, $depth, $flags);
    }

    public function render(array $payload = [])
    {
        return View::parse($this->value, $payload);
    }

    public function markdown(array $payload = [])
    {
        return Str::markdown(View::parse($this->value, $payload));
    }

    public function tel($text = null, array $attributes = []): string
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

    public function sms($text = null, array $attributes = []): string
    {
        if (!$phone = $this->object->getValue()) {
            return null;
        }

        return HtmlFacade::link(
            'sms:' . preg_replace('/[^\+\d]/', '', $phone),
            $text ?: $phone,
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
