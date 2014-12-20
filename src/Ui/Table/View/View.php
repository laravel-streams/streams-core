<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class View
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View
 */
class View implements ViewInterface
{

    /**
     * The view text.
     *
     * @var
     */
    protected $text;

    /**
     * The view slug.
     *
     * @var
     */
    protected $slug;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active;

    /**
     * The view prefix.
     *
     * @var null
     */
    protected $prefix;

    /**
     * The view handler.
     *
     * @var null
     */
    protected $handler;

    /**
     * The view's attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * Create a new View instance.
     *
     * @param       $text
     * @param       $slug
     * @param bool  $active
     * @param null  $prefix
     * @param null  $handler
     * @param array $attributes
     */
    public function __construct($text, $slug, $active = false, $prefix = null, $handler = null, array $attributes = [])
    {
        $this->text       = $text;
        $this->slug       = $slug;
        $this->active     = $active;
        $this->prefix     = $prefix;
        $this->handler    = $handler;
        $this->attributes = $attributes;
    }

    /**
     * Hook into the table query.
     *
     * @param TableBuilder $builder
     * @param Builder      $query
     */
    public function onTableQuerying(TableBuilder $builder, Builder $query)
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
        $url        = $this->getUrl();
        $active     = $this->isActive();
        $text       = trans($this->getText());
        $attributes = app('html')->attributes($this->getAttributes());

        return compact('active', 'text', 'url', 'attributes');
    }

    /**
     * Set the attributes.
     *
     * @param  array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Get the attributes.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set the active flag.
     *
     * @param  $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = ($active);

        return $this;
    }

    /**
     * Return the active flag.
     *
     * @return bool
     */
    public function isActive()
    {
        return ($this->active);
    }

    /**
     * Set the handler.
     *
     * @param  $handler
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the handler.
     *
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
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
     * Set the text.
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
     * Get the text.
     *
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the view's URL.
     *
     * @return string
     */
    protected function getUrl()
    {
        return url(app('request')->path() . '?' . $this->getPrefix() . 'view=' . $this->getSlug());
    }
}
