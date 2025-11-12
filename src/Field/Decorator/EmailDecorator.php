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

        // Convert email to HTML entities to obfuscate it
        $safe = '';
        
        foreach (str_split($this->value) as $char) {
            if (ord($char) > 128) {
                $safe .= '&#' . ord($char) . ';';
            } else {
                // Randomly use decimal or hex encoding for ASCII characters
                $safe .= rand(1, 2) === 1 
                    ? '&#' . ord($char) . ';' 
                    : '&#x' . dechex(ord($char)) . ';';
            }
        }
        
        return $safe;
    }

    public function __toString()
    {
        return (string) $this->mailto();
    }
}
