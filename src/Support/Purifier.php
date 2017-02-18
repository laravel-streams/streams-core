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
        preg_match("/\<pre\>((.|\n)*?)\<\/pre\>/", $html, $pres);
        preg_match("/\<code\>((.|\n)*?)\<\/code\>/", $html, $codes);

        $html = preg_replace("/\<pre\>((.|\n)*?)\<\/pre\>/", ".PRE_PLACEHOLDER.", $html);
        $html = preg_replace("/\<code\>((.|\n)*?)\<\/code\>/", ".CODE_PLACEHOLDER.", $html);

        // Purify!
        $html = parent::purify($html, $config);

        /**
         * Replace the placeholders with the
         * complete <pre> and <code> blocks.
         */
        foreach ($pres as $pre) {
            $html = preg_replace('/.PRE_PLACEHOLDER./', $pre, $html, 1);
        }

        foreach ($codes as $code) {
            $html = preg_replace('/.CODE_PLACEHOLDER./', $code, $html, 1);
        }

        return $html;
    }
}
