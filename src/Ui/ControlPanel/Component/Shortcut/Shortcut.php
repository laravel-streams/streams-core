<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Ui\Traits\HasIcon;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;
use Anomaly\Streams\Platform\Ui\Contract\IconInterface;
use Anomaly\Streams\Platform\Ui\Traits\HasClassAttribute;
use Anomaly\Streams\Platform\Ui\Contract\ClassAttributeInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Shortcut\Contract\ShortcutInterface;

/**
 * Class Shortcut
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Shortcut implements ShortcutInterface, IconInterface, ClassAttributeInterface, Arrayable, Jsonable
{

    use HasIcon;
    use HasAttributes;
    use HasClassAttribute;

    /**
     * The shortcut attributes.
     *
     * @var array
     */
    protected $attributes = [
        //'type' => 'default',
    ];

    /**
     * The shortcut slug.
     *
     * @var null|string
     */
    protected $slug = null;

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
     * The shortcut policy.
     *
     * @var null|string|array
     */
    public $policy;

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
     * Get the HREF attribute.
     *
     * @param  null $path
     * @return string
     */
    public function getHref($path = null)
    {
        return array_get($this->attributes, 'href') . ($path ? '/' . $path : $path);
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
