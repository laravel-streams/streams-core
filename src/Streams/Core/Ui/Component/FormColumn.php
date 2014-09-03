<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\Contract\RenderableInterface;
use Streams\Core\Ui\FormUi;

class FormColumn extends FormComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The width of the column.
     *
     * @var int
     */
    protected $width = 24;

    /**
     * The fields for the column.
     *
     * @var null
     */
    protected $fields = [];

    /**
     * Create a new FormColumn instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;

        $this->formField = $ui->newFormField();
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $width  = $this->buildWidth();
        $fields = $this->buildFields();

        return \View::make($this->view ?: 'streams/partials/form/column', compact('width', 'fields'));
    }

    /**
     * Return the width of the column.
     *
     * @return string
     */
    protected function buildWidth()
    {
        return \StreamsHelper::value($this->width, [$this]);
    }

    /**
     * Build the fields for the form section.
     *
     * @return array
     */
    protected function buildFields()
    {
        $fields = $this->fields;

        if ($fields instanceof \Closure) {
            $fields = \StreamsHelper::value($fields, [$this]);
        }

        foreach ($fields as &$options) {

            if ($options instanceof RenderableInterface) {
                $options = ['field' => $options];
                continue;
            }

            if (is_string($options)) {
                $options = [
                    'field' => $options,
                ];
            }

            $field = clone($this->formField);

            $field->setField(\ArrayHelper::value($options, 'field', null, [$this]));

            $options = compact('field');
        }

        return $this->ui->newFormFieldCollection($fields);
    }

    /**
     * Set the fields array.
     *
     * @param null $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Set the width of the column.
     *
     * @param $width
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}
