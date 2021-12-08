<?php

namespace Streams\Core\Support\Macros;

use League\CommonMark\MarkdownConverter;

/**
 * @param       $text
 * @return string
 */
class StrMarkdown
{
    public function __invoke()
    {
        return
            /**
             * @param       $text
             * @return string
             */ function ($text) {
            return app(MarkdownConverter::class)->convertToHtml($text)->getContent();
        };
    }

}
