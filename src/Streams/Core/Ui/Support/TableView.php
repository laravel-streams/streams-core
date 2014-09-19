<?php namespace Streams\Core\Ui\Support;

use Streams\Core\Traits\CallableTrait;
use Streams\Core\Ui\Contract\TableViewInterface;

class TableView implements TableViewInterface
{
    use CallableTrait;

    /**
     * The view slug.
     *
     * @var null
     */
    protected $slug = null;

    /**
     * The active flag.
     *
     * @var bool
     */
    protected $active = false;

    /**
     * The views options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Create a new TableView instance.
     *
     * @param         $options
     */
    public function __construct($options)
    {
        if (isset($options['callbacks'])) {
            $this->callbacks = $options['callbacks'];

            unset($options['callbacks']);
        }

        if (isset($options['slug'])) {
            $this->slug = $options['slug'];
        } elseif (isset($options['title'])) {
            $this->slug = slugify($options['title']);
        } else {
            $this->slug = 'default';
        }

        $this->options = $options;
    }

    /**
     * Return an option value.
     *
     * @param      $option
     * @param null $default
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return isset($this->options[$option]) ? $this->options[$option] : $default;
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
     * Set the active state.
     *
     * @param $state
     * @return $this|mixed
     */
    public function setActive($state)
    {
        $this->active = $state;

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
}