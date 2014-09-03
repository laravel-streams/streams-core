<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\Contract\RenderableInterface;
use Streams\Core\Ui\TableUi;

class TableRow extends TableComponent
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
     * Create a new TableRow instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui = null)
    {
        $this->ui = $ui;

        $this->tableColumn = $ui->newTableColumn();
        $this->tableButton = $ui->newTableButton();
    }

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        $columns = $this->buildColumns();
        $buttons = $this->buildButtons();

        return \View::make($this->view ? : 'streams/partials/table/row', compact('columns', 'buttons'));
    }

    /**
     * Return a collection of TableColumn components.
     *
     * @return \Streams\Ui\Collection\TableColumnCollection
     */
    protected function buildColumns()
    {
        $columns = $this->ui->getColumns();

        if ($columns instanceof \Closure) {
            $columns = \StreamsHelper::value($columns, [$this]);
        }

        foreach ($columns as &$options) {

            if (isset($options['column']) and $options['column'] instanceof RenderableInterface) {
                $options['column']->setEntry($this->entry);
                continue;
            }

            if (is_string($options)) {
                $options = ['field' => $options];
            }

            $column = clone($this->tableColumn);

            $column->setEntry($this->entry);

            $column->setView(\ArrayHelper::value($options, 'view', null, [$this]));
            $column->setField(\ArrayHelper::value($options, 'field', null, [$this]));
            $column->setColumn(\ArrayHelper::value($options, 'column', null, [$this]));
            $column->setAttributes(\ArrayHelper::value($options, 'attributes', null, [$this]));

            $options = compact('column');
        }

        return $this->ui->newTableColumnCollection($columns);
    }

    /**
     * Return a collection of TableButton components.
     *
     * @return \Streams\Ui\Collection\TableButtonCollection
     */
    protected function buildButtons()
    {
        $buttons = $this->ui->getButtons();

        if ($buttons instanceof \Closure) {
            $buttons = \StreamsHelper::value($buttons, [$this]);
        }

        foreach ($buttons as &$options) {

            $button = clone($this->tableButton);

            $button->setEntry($this->entry);

            if ($options instanceof \Closure) {
                $options = \StreamsHelper::value($options, [$this]);
            }

            $button->setView(\ArrayHelper::value($options, 'view', null, [$this]));
            $button->setTitle(\ArrayHelper::value($options, 'title', null, [$this]));
            $button->setAttributes(\ArrayHelper::value($options, 'attributes', null, [$this]));

            $options = compact('button');
        }

        return $this->ui->newTableButtonCollection($buttons);
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
}
