<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\FormUi;

class FormTab extends FormComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The title of the section.
     *
     * @var null
     */
    protected $title = null;

    /**
     * The layout for the section.
     *
     * @var null
     */
    protected $layout = null;

    /**
     * Create a new FormTab instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;

        $this->formRow = $ui->newFormRow();
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $title = $this->buildTitle();
        $rows  = $this->buildRows();

        return \View::make($this->view ?: 'streams/partials/form/tab', compact('title', 'rows'));
    }

    /**
     * Build the title of the section.
     *
     * @return mixed
     */
    protected function buildTitle()
    {
        $title = \StreamsHelper::value($this->title, [$this]);

        return \Lang::trans($title);
    }

    /**
     * Build the rows for the section.
     *
     * @return array
     */
    protected function buildRows()
    {
        $rows = $this->layout;

        if ($rows instanceof \Closure) {
            $rows = \StreamsHelper::value($rows, [$this]);
        }

        foreach ($rows as &$options) {

            // What would overriding look like here?

            $row = $this->formRow;

            $row->setColumns(\ArrayHelper::value($options, 'columns', [], [$this]));

            $options = compact('row');
        }

        return $this->ui->newFormRowCollection($rows);
    }

    /**
     * Set the section title.
     *
     * @param null $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Set the layout for the section.
     *
     * @param array $rows
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }
}
