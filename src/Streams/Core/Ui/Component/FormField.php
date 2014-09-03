<?php namespace Streams\Core\Ui\Component;

class FormField extends FormComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The field slug.
     *
     * @var null
     */
    protected $field = null;

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $fieldType = $this->buildFieldType();

        return \View::make($this->view ?: 'streams/partials/form/field', compact('fieldType'));
    }

    /**
     * Build the form field type.
     *
     * @return string
     */
    protected function buildFieldType()
    {
        return $this->ui->getModel()->fieldType($this->field)->setEntry($this->ui->getEntry());
    }

    /**
     * Set the field slug.
     *
     * @param null $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }
}
