<?php

namespace Streams\Core\Field\Decorator;

use Spatie\Html\Facades\Html;
class EmailDecorator extends StringDecorator
{
    public function mailto(
        $title = null,
        $attributes = [],
        $default = null,
        $escape = true
    ): string {

        $email = $default ?: $this->value;

        if (! $title) {
            $title = $email;
        }

        return Html::mailto($email, $title, $attributes, $escape);
    }

    public function obfuscate(): ?string
    {
        if (! $this->value) {
            return null;
        }

        return Html::obfuscate($this->value);
    }

    public function __toString()
    {
        return (string) $this->mailto();
    }
}
