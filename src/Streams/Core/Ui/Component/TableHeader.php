<?php namespace Streams\Core\Ui\Component;

class TableHeader extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = 'streams/partials/table/header';

    /**
     * The field option.
     *
     * @var null
     */
    protected $field = null;

    /**
     * The header option.
     *
     * @var null
     */
    protected $header = null;

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
        $header = $this->buildHeader();

        return \View::make($this->view, compact('header'));
    }

    /**
     * Return the column data.
     *
     * @return string
     */
    protected function buildHeader()
    {
        if ($this->header) {
            $header = \StreamsHelper::value($this->header, [$this]);
        } else {
            $header = $this->field;

            if ($assignment = $this->ui->getModel()->findAssignmentBySlug($header)) {
                $header = $assignment->field->name;
            } else {
                $header = \StringHelper::humanize($header);
            }
        }

        return \Lang::trans($header);
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
     * Set the header option.
     *
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;

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
