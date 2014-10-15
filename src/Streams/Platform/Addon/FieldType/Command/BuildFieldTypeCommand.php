<?php namespace Streams\Platform\Addon\FieldType\Command;

class BuildFieldTypeCommand
{
    protected $type;

    protected $slug;

    protected $value;

    protected $locale;

    function __construct($type, $slug, $value, $locale, $prefix)
    {
        $this->slug   = $slug;
        $this->type   = $type;
        $this->value  = $value;
        $this->locale = $locale;
    }

}
 