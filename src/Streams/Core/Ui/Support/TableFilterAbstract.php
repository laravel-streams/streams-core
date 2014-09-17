<?php namespace Streams\Core\Ui\Support;

use Streams\Core\Ui\TableUi;
use Streams\Core\Traits\CallableTrait;
use Streams\Core\Ui\Contract\TableFilterInterface;

abstract class TableFilterAbstract implements TableFilterInterface
{
    use CallableTrait;

    /**
     * The filter options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The UI object.
     *
     * @var \Streams\Core\Ui\TableUi
     */
    protected $ui;

    /**
     * Create a new TableFilterAbstract instance.
     *
     * @param TableUi $ui
     * @param         $options
     */
    public function __construct(TableUi $ui, $options)
    {
        $this->ui = $ui;

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

        $this->active = (\Input::get('view') == $this->slug);
    }

    /**
     * Return the filter input.
     *
     * @return null|string
     */
    public function input()
    {
        return null;
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
}