<?php

namespace Streams\Core\Field\Types;

use Illuminate\Support\Str;
use Streams\Core\Field\Field;
use Streams\Core\Field\Presenter\MarkdownPresenter;

class MarkdownFieldType extends Field
{

    public function getPresenterName()
    {
        return MarkdownPresenter::class;
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
