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
     * The display configuration.
     *
     * @var \HTMLPurifier_Config
     */
    protected $display;

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
     * Return text for display with only
     * the permitted HTML left in it.
     *
     * @param  mixed $html
     * @return mixed
     */
    public function display($html)
    {
        if (!is_string($html) || $html === '') {
            return $html;
        }

        if (!$this->display) {
            $this->display = \HTMLPurifier_Config::createDefault();

            $this->display->set('HTML.Allowed', config('streams::security.display.allowed'));
            $this->display->set('Attr.AllowedFrameTargets', config('streams::security.display.targets'));
            $this->display->set('Cache.SerializerPath', app_storage_path('support/purifier'));
        }

        return $this->purify($html, $this->display);
    }

}
