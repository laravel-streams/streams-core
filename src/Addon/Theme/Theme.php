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
     * Get the meta data.
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
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

    /**
     * Get the theme's tag class.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }
}
