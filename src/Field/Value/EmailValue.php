<?php

namespace Streams\Core\Field\Value;

use Collective\Html\HtmlFacade;

class EmailValue extends StringValue
{

    /**
     * Return a mailto link.
     *
     * @param  null $text
     * @return bool
     */
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
