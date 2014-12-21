<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
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
class Action extends Button implements ActionInterface
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
     * @param null   $tablePostHandler
     * @param string $type
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
        $tablePostHandler = null,
        $type = 'default',
        array $dropdown = [],
        array $attributes = []
    ) {

        $this->slug             = $slug;
        $this->prefix           = $prefix;
        $this->active           = $active;
        $this->tablePostHandler = $tablePostHandler;

        $attributes['type']  = 'submit';
        $attributes['name']  = 'action';
        $attributes['value'] = $slug;

        parent::__construct($text, $icon, $class, $type, $dropdown, $attributes);
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
}
