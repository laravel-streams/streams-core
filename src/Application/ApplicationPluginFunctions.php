<?php namespace Anomaly\Streams\Platform\Application;

/**
 * Class ApplicationPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application
 */
class ApplicationPluginFunctions
{

    /**
     * Return an environmental variable.
     *
     * @param      $key
     * @param null $default
     * @return mixed
     */
    public function env($key, $default = null)
    {
        return env($key, $default);
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
        if (mb_strlen($value) <= $limit) {
            return $value;
        }

        $cutArea = mb_substr($value, $limit - 1, 2, 'UTF-8');

        if (strpos($cutArea, ' ') === false) {

            $value = mb_substr($value, 0, $limit, 'UTF-8');

            $spacePos = strrpos($value, ' ');

            if ($spacePos !== false) {
                return rtrim(mb_substr($value, 0, $spacePos, 'UTF-8')) . $end;
            }
        }

        return rtrim(mb_substr($value, 0, $limit, 'UTF-8')) . $end;
    }
}
