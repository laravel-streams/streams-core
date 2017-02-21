<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class Purifier
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Purifier extends \HTMLPurifier
{

    /**
     * Create a new Purifier instance.
     *
     * @param null $config
     */
    public function __construct($config = null)
    {
        parent::__construct($config);

        $cache = app_storage_path('support/purifier');

        if (!is_dir($cache)) {
            mkdir($cache, 0777, true);
        }

        $this->config->set('Cache.SerializerPath', $cache);
    }

    /**
     * Return purified HTML.
     *
     * @param string $html
     * @param null   $config
     * @return string
     */
    public function purify($html, $config = null)
    {
        /**
         * Replace <pre> and <code> blocks
         * that are complete with placeholders.
         */
        preg_match_all("/\<pre\>(.+?)\<\/pre\>/s", $html, $pres, PREG_PATTERN_ORDER);
        preg_match_all("/\<code\>(.+?)\<\/code\>/s", $html, $codes, PREG_PATTERN_ORDER);

        $html = preg_replace("/\<pre\>(.+?)\<\/pre\>/s", "PRE_PLACEHOLDER", $html);
        $html = preg_replace("/\<code\>(.+?)\<\/code\>/s", "CODE_PLACEHOLDER", $html);

        // Purify!
        $html = parent::purify($html, $config);

        /**
         * Replace the placeholders with the
         * complete <pre> and <code> blocks.
         */
        if (isset($pres[0])) {
            foreach ($pres[0] as $pre) {
                $html = preg_replace('/PRE_PLACEHOLDER/', $pre, $html, 1);
            }
        }

        if (isset($codes[0])) {
            foreach ($codes[0] as $code) {
                $html = preg_replace('/CODE_PLACEHOLDER/', $code, $html, 1);
            }
        }

        return $html;
    }
}
