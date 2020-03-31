<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Traits\HasIcon;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;
use Anomaly\Streams\Platform\Ui\Traits\HasHtmlAttributes;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;

/**
 * Class Section
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Section implements SectionInterface, Arrayable, Jsonable
{
    use HasIcon;
    use HasClassAttribute;
    use HasHtmlAttributes;

    /**
     * The section slug.
     *
     * @var null|string
     */
    protected $slug = null;

    /**
     * The section title.
     *
     * @var null|string
     */
    protected $title = null;

    /**
     * The section label.
     *
     * @var null|string
     */
    protected $label = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The path matcher.
     *
     * @var null|string
     */
    protected $matcher = null;

    /**
     * The section permalink.
     *
     * @var null|string
     */
    protected $permalink = null;

    /**
     * The section description.
     *
     * @var null|string
     */
    protected $description = null;

    /**
     * The highlighted flag.
     *
     * @var bool
     */
    protected $highlighted = false;

    /**
     * The section context.
     *
     * @var string
     */
    protected $context = 'danger';

    /**
     * The section parent.
     *
     * @var null|string
     */
    protected $parent = null;

    /**
     * Section buttons. These are only to
     * transport input to the button builder.
     *
     * @var array
     */
    protected $buttons = [];

    /**
     * The section permission.
     *
     * @var null|string
     */
    protected $permission = null;

    /**
     * The section breadcrumb.
     *
     * @var null|string
     */
    protected $breadcrumb = null;

    /**
     * If the section will be hidden from the Control Panel.
     *
     * @var bool
     */
    protected $hidden = false;

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
     * Get the active flag.
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the active flag.
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the matcher.
     *
     * @return null|string
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * Set the matcher.
     *
     * @param $matcher
     * @return $this
     */
    public function setMatcher($matcher)
    {
        $this->matcher = $matcher;

        return $this;
    }

    /**
     * Get the permalink.
     *
     * @return null|string
     */
    public function getPermalink()
    {
        return $this->permalink;
    }

    /**
     * Set the permalink.
     *
     * @param $permalink
     * @return $this
     */
    public function setPermalink($permalink)
    {
        $this->permalink = $permalink;

        return $this;
    }

    /**
     * Get the description.
     *
     * @return null|string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the description.
     *
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * Get the parent.
     *
     * @return null|string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Return if the section is
     * a sub-section or not.
     *
     * @return bool
     */
    public function isSubSection()
    {
        return (bool) $this->getParent();
    }

    /**
     * Set the parent.
     *
     * @param $parent
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get the buttons.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Set the buttons.
     *
     * @param array $buttons
     */
    public function setButtons($buttons)
    {
        $this->buttons = $buttons;
    }

    /**
     * Get the permission.
     *
     * @return null|string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the permission.
     *
     * @param $permission
     * @return $this
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get the breadcrumb.
     *
     * @return null|string
     */
    public function getBreadcrumb()
    {
        return $this->breadcrumb;
    }

    /**
     * Set the breadcrumb.
     *
     * @param $breadcrumb
     * @return $this
     */
    public function setBreadcrumb($breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;

        return $this;
    }

    /**
     * Get the hidden flag.
     *
     * @return bool
     */
    public function isHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the hidden flag.
     *
     * @param $hidden
     * @return $this
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

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
        return ($this->getPermalink() ?: array_get($this->attributes, 'href')) . ($path ? '/' . $path : $path);
    }

    /**
     * Return the child sections.
     *
     * @return SectionCollection
     */
    public function getChildren()
    {
        return app(SectionCollection::class)->children($this->getSlug());
    }

    /**
     * Return whether the section
     * has children or not.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return !$this->getChildren()->isEmpty();
    }

    /**
     * Return merged attributes.
     *
     * @param array $attributes
     */
    public function attributes(array $attributes = [])
    {
        return array_merge($this->attributes, [
            'class' => $this->class(),
        ], $attributes);
    }

    /**
     * Return class HTML.
     *
     * @param string $class
     * @return null|string
     */
    public function class($class = null)
    {
        return trim(implode(' ', [
            $class,
            $this->getClass(),
            $this->isActive() ? 'active' : null,
            $this->isHighlighted() ? 'highlighted' : null,
        ]));
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return Hydrator::dehydrate($this);
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}
