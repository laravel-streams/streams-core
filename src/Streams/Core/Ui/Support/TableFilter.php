<?php namespace Streams\Core\Ui\Support;

use Streams\Core\Ui\TableUi;
use Streams\Core\Ui\Contract\TableFilterInterface;

class TableFilter implements TableFilterInterface
{
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

        $this->options = $options;
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
     * Build onto the query.
     *
     * @param $query
     * @return null
     */
    public function query($query)
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