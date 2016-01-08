<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Str
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Str
{

    /**
     * Return a humanized string.
     *
     * @param        $value
     * @param string $separator
     * @return string
     */
    public function humanize($value, $separator = '_')
    {
        return ucwords(preg_replace('/[' . $separator . ']+/', ' ', strtolower(trim($value))));
    }

    /**
     * Limit the number of characters in a string
     * while preserving words.
     *
     * https://github.com/laravel/framework/pull/3547/files
     *
     * @param  string $value
     * @param  int    $limit
     * @param  string $end
     * @return string
     */
    public function truncate($value, $limit = 100, $end = '...')
    {
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
}
