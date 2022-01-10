<?php

namespace Streams\Core\Field\Type;

use Streams\Core\Field\Field;
use Streams\Core\Field\Value\TemplateValue;

class Template extends Field
{
    public function modify($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return (string) $value;
    }

    public function restore($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return (string) $value;
    }

    public function getValueName()
    {
        return TemplateValue::class;
    }

    public function generate()
    {
        return $this->generator()->randomHtml();
    }
}
