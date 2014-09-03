<?php namespace Streams\Core\Ui\Component;

class TableColumn extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The field option.
     *
     * @var null
     */
    protected $field = null;

    /**
     * The column option.
     *
     * @var null
     */
    protected $column = null;

    /**
     * The attributes option.
     *
     * @var null
     */
    protected $attributes = null;

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        $data = $this->buildData();

        return \View::make($this->view ?: 'streams/partials/table/column', compact('data'));
    }

    /**
     * Return the column data.
     *
     * @return string
     */
    protected function buildData()
    {
        if ($this->field) {
            return $this->entry->{$this->field};
        } elseif ($this->column) {
            return \StreamsHelper::value($this->column, [$this]);
        }

        return null;
    }

    /**
     * Set the view option.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the entry object.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry object.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Set the field option.
     *
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Set the column option.
     *
     * @param $column
     * @return $this
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Set the attributes option.
     *
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }
}
