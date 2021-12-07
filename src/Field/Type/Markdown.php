<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\MarkdownValue;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Markdown extends FieldType
{

    public function expand($value)
    {
        return new MarkdownValue($value);
    }

    public function schema()
    {
        return Schema::string($this->field->handle);
    }

    public function generate()
    {
        $title = Str::title($this->generator()->sentence());
        $heading = Str::title($this->generator()->sentence(3));
        $paragraph = $this->generator()->paragraph();
        $text = $this->generator()->text(15, 25);
        $url = $this->generator()->url();

        return implode("\n\n", [
            "# {$title}",
            "[{$text}]({$url})",
            "### {$heading}",
            "{$paragraph}",
        ]);
    }
}
