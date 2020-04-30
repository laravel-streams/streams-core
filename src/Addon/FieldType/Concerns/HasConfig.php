<?php

namespace Anomaly\Streams\Platform\Addon\FieldType\Concerns;

/**
 * Trait HasConfig
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
trait HasConfig
{

    /**
     * Configuration options.
     *
     * @var array
     */
    public $config = [];

    /**
     * Return a config value.
     *
     * @param        $key
     * @param  null $default
     * @return mixed
     */
    public function config($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * Get the config options.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Merge configuration.
     *
     * @param  array $config
     * @return $this
     */
    public function mergeConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }

    /**
     * Set a config value.
     *
     * @param $key
     * @param $value
     * @return $this
     */
    public function configSet($key, $value)
    {
        array_set($this->config, $key, $value);

        return $this;
    }
}
