<?php

namespace Streams\Core\Field\Type;

use Illuminate\Support\Str;
use Streams\Core\Field\FieldType;
use Streams\Core\Field\Value\MarkdownValue;

class Markdown extends FieldType
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

    public function expand($value)
    {
        return new MarkdownValue($value);
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
