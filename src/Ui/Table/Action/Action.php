<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class Action
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action
 */
class Action implements ActionInterface
{

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active;

    /**
     * The action's prefix.
     *
     * @var string|null
     */
    protected $prefix;

    /**
     * The action slug.
     *
     * @var string|null
     */
    protected $slug;

    /**
     * The action text.
     *
     * @var null
     */
    protected $text;

    /**
     * The action icon.
     *
     * @var null
     */
    protected $icon;

    /**
     * The action type.
     *
     * @var string
     */
    protected $type;

    /**
     * The action class.
     *
     * @var null
     */
    protected $class;

    /**
     * The action's dropdown.
     *
     * @var array
     */
    protected $dropdown;

    /**
     * The action's attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * The table post handler.
     *
     * @var null
     */
    protected $tablePostHandler;

    /**
     * Create a new Action instance.
     *
     * @param null   $slug
     * @param null   $text
     * @param null   $icon
     * @param null   $class
     * @param null   $prefix
     * @param bool   $active
     * @param string $type
     * @param null   $tablePostHandler
     * @param array  $dropdown
     * @param array  $attributes
     */
    public function __construct(
        $slug,
        $text = null,
        $icon = null,
        $class = null,
        $prefix = null,
        $active = false,
        $type = 'default',
        $tablePostHandler = null,
        array $dropdown = [],
        array $attributes = []
    ) {
        $this->slug             = $slug;
        $this->icon             = $icon;
        $this->text             = $text;
        $this->type             = $type;
        $this->class            = $class;
        $this->prefix           = $prefix;
        $this->active           = $active;
        $this->dropdown         = $dropdown;
        $this->tablePostHandler = $tablePostHandler;

        $attributes['type']  = 'submit';
        $attributes['name']  = 'action';
        $attributes['value'] = $slug;

        $this->attributes = $attributes;
    }

    /**
     * Hook into the table querying event.
     *
     * @param TableBuilder $builder
     */
    public function onTablePost(TableBuilder $builder)
    {
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function toArray()
    {
        $type       = $this->getType();
        $icon       = $this->getIcon();
        $text       = $this->getText();
        $class      = $this->getClass();
        $dropdown   = $this->getDropdown();
        $attributes = $this->getAttributes();

        if (is_string($text)) {
            $text = trans($text);
        }

        $data = compact('text', 'type', 'class', 'icon', 'attributes', 'dropdown');

        $data['attributes'] = app('html')->attributes($data['attributes']);

        $data['active'] = $this->isActive();

        return $data;
    }

    /**
     * Set the tablePostHandler handler.
     *
     * @param  $tablePostHandler
     * @return $this
     */
    public function setTablePostHandler($tablePostHandler)
    {
        $this->tablePostHandler = $tablePostHandler;

        return $this;
    }

    /**
     * Get the tablePostHandler handler.
     *
     * @return mixed
     */
    public function getTablePostHandler()
    {
        return $this->tablePostHandler;
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
     * Return the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set the prefix.
     *
     * @param  $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the slug.
     *
     * @param  $slug
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the action dropdown.
     *
     * @param array $dropdown
     * @return $this
     */
    public function setDropdown(array $dropdown)
    {
        $this->dropdown = $dropdown;

        return $this;
    }

    /**
     * Get the action dropdown.
     *
     * @return array
     */
    public function getDropdown()
    {
        return $this->dropdown;
    }

    /**
     * Set the action attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get the action attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the action class.
     *
     * @param  $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * Get the action class.
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Set the icon.
     *
     * @param  $icon
     * @return $this
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the icon.
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the action text.
     *
     * @param  $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the action text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the action type.
     *
     * @param  $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the action type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
