<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\FormUi;

class FormRow extends FormComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The columns for the row.
     *
     * @var array
     */
    protected $columns = [];

    /**
     * Create a new FormRow instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;

        $this->formColumn = $ui->newFormColumn();
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $columns = $this->buildColumns();

        return \View::make($this->view ? : 'streams/partials/form/row', compact('columns'));
    }

    /**
     * Build the columns for the row.
     *
     * @return array
     */
    protected function buildColumns()
    {
        $columns = $this->columns;

        if ($columns instanceof \Closure) {
            $columns = \StreamsHelper::value($columns, [$this]);
        }

        foreach ($columns as &$options) {

            // What would overriding look like here?

            $column = $this->formColumn;

            $column->setWidth(\ArrayHelper::value($options, 'width', null, [$this]));
            $column->setFields(\ArrayHelper::value($options, 'fields', [], [$this]));

            $options = compact('column');
        }

        return $this->ui->newFormColumnCollection($columns);
    }

    /**
     * Set the columns for the row.
     *
     * @param null $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;

        return $this;
    }
}
