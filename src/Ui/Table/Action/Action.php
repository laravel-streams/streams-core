<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Button\Button;
use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionInterface;
use Anomaly\Streams\Platform\Ui\Table\Event\TablePostEvent;

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
     * The onTablePost handler.
     *
     * @var null
     */
    protected $onTablePost;

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
     * Create a new Action instance.
     *
     * @param null   $slug
     * @param null   $text
     * @param null   $icon
     * @param null   $class
     * @param null   $prefix
     * @param bool   $active
     * @param string $type
     * @param null   $onTablePost
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
        $onTablePost = null,
        array $attributes = []
    ) {
        $this->slug        = $slug;
        $this->prefix      = $prefix;
        $this->active      = $active;
        $this->onTablePost = $onTablePost;

        $attributes['type'] = 'submit';
        $attributes['name'] = 'action';

        parent::__construct($attributes, $class, $icon, $text, $type);
    }

    /**
     * Hook into the table querying event.
     *
     * @param TablePostEvent $event
     */
    public function onTablePost(TablePostEvent $event)
    {
    }

    /**
     * Return the view data.
     *
     * @param  array $arguments
     * @return array
     */
    public function getTableData()
    {
        $data = parent::getTableData();

        $data['slug']   = $this->getSlug();
        $data['active'] = $this->isActive();

        return $data;
    }

    /**
     * Set the onTablePost handler.
     *
     * @param  $onTablePost
     * @return $this
     */
    public function setOnTablePost($onTablePost)
    {
        $this->onTablePost = $onTablePost;

        return $this;
    }

    /**
     * Get the onTablePost handler.
     *
     * @return mixed
     */
    public function getOnTablePost()
    {
        return $this->onTablePost;
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
