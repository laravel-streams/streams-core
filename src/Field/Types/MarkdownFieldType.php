<?php

namespace Streams\Core\Field\Types;

use Streams\Core\Field\Field;
use Streams\Core\Field\Decorator\MarkdownDecorator;

class MarkdownFieldType extends Field
{
    public function getDecoratorName()
    {
        return MarkdownDecorator::class;
    }

    // public function generate()
    // {
    //     $title = Str::title($this->generator()->sentence());
    //     $heading = Str::title($this->generator()->sentence(3));
    //     $paragraph = $this->generator()->paragraph();
    //     $text = $this->generator()->text(15, 25);
    //     $url = $this->generator()->url();

    //     return implode("\n\n", [
    //         "# {$title}",
    //         "[{$text}]({$url})",
    //         "### {$heading}",
    //         "{$paragraph}",
    //     ]);
    // }
}
