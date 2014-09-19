<?php namespace Streams\Core\Ui\Builder;

use Streams\Core\Ui\Contract\BuilderInterface;
use Streams\Core\Ui\TableUi;

class TableRowBuilder extends TableBuilderAbstract
{
    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Create a new TableRowBuilder instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui)
    {
        parent::__construct($ui);

        $this->columnBuilder = $this->ui->newColumnBuilder($ui);
        $this->buttonBuilder = $this->ui->newButtonBuilder($ui);
    }

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $class   = $this->buildClass();
        $columns = $this->buildColumns();
        $buttons = $this->buildButtons();

        return compact('class', 'columns', 'buttons');
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        return evaluate($this->ui->getRowClass(), null, [$this->ui, $this->entry]);
    }

    /**
     * Return the columns.
     *
     * @return array
     */
    protected function buildColumns()
    {
        $columns = [];

        foreach ($this->ui->getColumns() as $options) {
            if ($options instanceof BuilderInterface) {
                $columns[] = $options->setEntry($this->entry)->setOptions($options)->data();
            } else {
                $columns[] = $this->columnBuilder->setEntry($this->entry)->setOptions($options)->data();
            }
        }

        return $columns;
    }

    /**
     * Return the buttons.
     *
     * @return array
     */
    protected function buildButtons()
    {
        $buttons = [];

        foreach ($this->ui->getButtons() as $options) {
            $buttons[] = $this->buttonBuilder->setEntry($this->entry)->setOptions($options)->data();
        }

        return $buttons;
    }

    /**
     * Set the entry.
     *
     * @param null $entry
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }
}
