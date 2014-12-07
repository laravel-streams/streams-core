<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Parser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Parser
{

    /**
     * Return the value in string form.
     *
     * @param      $value
     * @param bool $escape
     * @return string
     */
    protected function toString($value, $escape = false)
    {
        if (is_null($value)) {

            return 'null';
        } elseif (is_bool($value)) {

            if ($value) {

                return 'true';
            } else {

                return 'false';
            }
        } elseif (is_array($value)) {

            return "'" . serialize($value) . "'";
        }

        if ($escape) {

            $value = addslashes($value);
        }

        return "'" . $value . "'";
    }

    /**
     * Repeat a blank space $n times.
     *
     * @param $n
     * @return string
     */
    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }
}
 