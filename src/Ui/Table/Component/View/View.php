<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\Component\View\Contract\ViewInterface;

/**
 * Class View
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class View implements ViewInterface
{

    /**
     * The view slug.
     *
     * @var null|string
     */
    protected $slug = null;

    /**
     * The view text.
     *
     * @var null|string
     */
    protected $text = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The view prefix.
     *
     * @var string
     */
    protected $prefix = null;

    /**
     * The attributes array.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The view handler.
     *
     * @var mixed
     */
    protected $handler = 'Anomaly\Streams\Platform\Ui\Table\Component\View\ViewHandler@handle';

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
     * Set the attributes.
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
     * Set the view handler.
     *
     * @param $handler
     * @return $this
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * Get the view handler.
     *
     * @return mixed
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Set the active flag.
     *
     * @param bool $active
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
     * Set the view prefix.
     *
     * @param $prefix
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * Get the view prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Set the view slug.
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
     * Get the view slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the view text.
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the view text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
