<?php

namespace Anomaly\Streams\Platform\Support;

use VStelmakh\UrlHighlight\Encoder\HtmlSpecialcharsEncoder;
use VStelmakh\UrlHighlight\Highlighter\HtmlHighlighter;
use VStelmakh\UrlHighlight\UrlHighlight;

/**
 * Class StringHelper
 *
 * Additional string helper functions.
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class StringHelper
{
    /**
     * Replace urls by html tags
     *
     * @param $text
     * @param array $options
     * @return string
     */
    public static function linkify($text, array $options = []): string
    {
        $encoder = new HtmlSpecialcharsEncoder();
        $highlighter = new HtmlHighlighter('http', $options['attr']);
        $urlHighlight = new UrlHighlight(null, $highlighter, $encoder);

        return $urlHighlight->highlightUrls($text);
    }
}
