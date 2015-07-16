<?php namespace Anomaly\Streams\Platform\Addon\Theme;

use Anomaly\Streams\Platform\Addon\Addon;

/**
 * Class Theme
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Addon\Theme
 */
class Theme extends Addon
{

    /**
     * Determines whether this is
     * an admin theme or not.
     *
     * @var bool
     */
    protected $admin = false;

    /**
     * Determines whether this is
     * the active theme or not.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * Determines whether this is
     * the currently rendering theme
     * or not.
     *
     * @var bool
     */
    protected $current = false;

    /**
     * Meta information.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * The theme's tag class.
     *
     * @var string
     */
    protected $tag = 'Anomaly\Streams\Platform\Addon\Theme\ThemeTag';

    /**
     * Get the admin flag.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * Set the active flag.
     *
     * @param  $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Return the current flag.
     *
     * @return bool
     */
    public function isCurrent()
    {
        return $this->current;
    }

    /**
     * Set the current flag.
     *
     * @param $current
     * @return $this
     */
    public function setCurrent($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get the meta data.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Set the meta data.
     *
     * @param  $meta
     * @return $this
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Put meta data.
     *
     * @param  $key
     * @param  $meta
     * @return $this
     */
    public function putMeta($key, $meta)
    {
        $this->meta[$key] = $meta;

        return $this;
    }

    /**
     * Pull meta data.
     *
     * @param       $key
     * @param  null $default
     * @return mixed
     */
    public function pullMeta($key, $default = null)
    {
        return array_get($this->meta, $key, $default);
    }

    /**
     * Get the theme's tag class.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set the theme's tag class.
     *
     * @param  $tag
     * @return $this
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }
}
