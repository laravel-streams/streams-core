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
     * Convert text to human readable
     *
     * @param $value
     * @param string $separator
     * @return string
     */
    public static function humanize(string $value, string $separator = '_'): string
    {
        return str_replace($separator, ' ', strtolower(trim($value)));
    }

    /**
     * Replace urls by html tags
     *
     * @param $text
     * @param array $options
     * @return string
     */
    public static function linkify(string $text, array $options = []): string
    {
        $encoder = new HtmlSpecialcharsEncoder();
        $highlighter = new HtmlHighlighter('http', $options['attr']);
        $urlHighlight = new UrlHighlight(null, $highlighter, $encoder);
        return $urlHighlight->highlightUrls($text);
    }

    /**
     * Truncate text to specified length
     *
     * @param $value
     * @param int $limit
     * @param string $end
     * @return string
     */
    public static function truncate(string $value, int $limit = 100, string $end = '...'): string
    {
        $length = mb_strlen($value);
        return $length > $limit
            ? mb_substr($value, 0, $limit) . $end
            : $value;
    }
}
