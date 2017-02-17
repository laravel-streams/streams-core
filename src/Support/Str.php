<?php namespace Anomaly\Streams\Platform\Support;

use Misd\Linkify\Linkify;

/**
 * Class Str
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Str extends \Illuminate\Support\Str
{

    /**
     * Return a humanized string.
     *
     * @param         $value
     * @param  string $separator
     * @return string
     */
    public function humanize($value, $separator = '_')
    {
        return preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value)));
    }

    /**
     * Limit the number of characters in a string
     * while preserving words.
     *
     * https://github.com/laravel/framework/pull/3547/files
     *
     * @param  string $value
     * @param  int $limit
     * @param  string $end
     * @return string
     */
    public function truncate($value, $limit = 100, $end = '...')
    {
        if (strlen($value) <= $limit) {
            return $value;
        }

        $parts = preg_split('/([\s\n\r]+)/', $value, null, PREG_SPLIT_DELIM_CAPTURE);
        $count = count($parts);

        $last   = 0;
        $length = 0;

        for (; $last < $count; ++$last) {
            $length += strlen($parts[$last]);

            if ($length > $limit) {
                break;
            }
        }

        return trim(implode(array_slice($parts, 0, $last))) . $end;
    }

    /**
     * Linkify the provided text.
     *
     * @param $text
     * @param array $options
     * @return string
     */
    public function linkify($text, array $options = [])
    {
        return (new Linkify($options))->process($text);
    }

    /**
     * Return safe HTML.
     *
     * @param $html
     */
    public function safe($html)
    {

        $html = preg_replace('@<iframe[^>]*?>.*?</script>@si', '', $html);
        $html = preg_replace('@<frame[^>]*?>.*?</script>@si', '', $html);

        $html = preg_replace('@<script[^>]*?>.*?</script>@si', '', $html);
        $html = preg_replace('@<style[^>]*?>.*?</style>@siU', '', $html);

        $html = preg_replace('/onload="(.*?)"/is', '', $html);
        $html = preg_replace('/onunload="(.*?)"/is', '', $html);

        $html = preg_replace('/onclick="(.*?)"/is', '', $html);
        $html = preg_replace('/ondblclick="(.*?)"/is', '', $html);

        $html = preg_replace('/onmousein="(.*?)"/is', '', $html);
        $html = preg_replace('/onmouseout="(.*?)"/is', '', $html);

        $html = preg_replace('/onmouseup="(.*?)"/is', '', $html);
        $html = preg_replace('/onmousedown="(.*?)"/is', '', $html);

        $html = preg_replace('/onchange="(.*?)"/is', '', $html);

        $html = preg_replace('@<![\s\S]*?–[ \t\n\r]*>@', '', $html); // Comments/CDATA

        return $html;
    }
}
