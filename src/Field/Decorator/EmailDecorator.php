<?php

namespace Streams\Core\Field\Decorator;

use Collective\Html\HtmlFacade;

class EmailDecorator extends StringDecorator
{
    public function mailto($email = null, $title = null, $attributes = [], $escape = true)
    {
        $email = $email ?: $this->value;

        if (!$title) {
            $title = $email;
        }

        return HtmlFacade::mailto($email, $title, $attributes, $escape);
    }

    /**
     * Normalize the URL by default.
     *
     * @return bool|string
     */
    public function __toString()
    {
        return (string) $this->mailto();
    }
}
