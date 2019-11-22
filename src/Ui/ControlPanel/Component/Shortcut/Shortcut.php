<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Contract\ShortcutInterface;
use Anomaly\Streams\Platform\Ui\Traits\HasHtmlAttributes;

/**
 * Class Shortcut
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Shortcut implements ShortcutInterface
{
    use HasHtmlAttributes;

    /**
     * The shortcut slug.
     *
     * @var null|string
     */
    protected $slug = null;

    /**
     * The shortcut icon.
     *
     * @var null|string
     */
    protected $icon = null;

    /**
     * The shortcut title.
     *
     * @var null|string
     */
    protected $title = null;

    /**
     * The shortcut label.
     *
     * @var null|string
     */
    protected $label = null;

    /**
     * The class.
     *
     * @var null|string
     */
    protected $class = 'shortcut';

    /**
     * The highlighted flag.
     *
     * @var bool
     */
    protected $highlighted = false;

    /**
     * The shortcut context.
     *
     * @var string
     */
    protected $context = 'danger';

    /**
     * The shortcut permission.
     *
     * @var null|string
     */
    protected $permission = null;

    /**
     * Get the slug.
     *
     * @return null|string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the slug.
     *
     * @param $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the icon.
     *
     * @return null|string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the icon.
     *
     * @param $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get the label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the label.
     *
     * @param  string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class . ' shortcut--' . $this->getSlug();
    }

    /**
     * Set the class.
     *
     * @param $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get the highlighted flag.
     *
     * @return boolean
     */
    public function isHighlighted()
    {
        return $this->highlighted;
    }

    /**
     * Set the highlighted flag.
     *
     * @param  boolean $active
     * @return $this
     */
    public function setHighlighted($highlighted)
    {
        $this->highlighted = $highlighted;

        return $this;
    }

    /**
     * Get the context.
     *
     * @return boolean
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Set the context flag.
     *
     * @param  boolean $active
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Get the permission.
     *
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the permission.
     *
     * @param  srtring $perission
     * @return $this
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get the HREF attribute.
     *
     * @param  null $path
     * @return string
     */
    public function getHref($path = null)
    {
        return array_get($this->attributes, 'href') . ($path ? '/' . $path : $path);
    }
}
