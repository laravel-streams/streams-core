<?php namespace Streams\Core\Ui\Builder;

use Streams\Core\Ui\FormUi;

class FormSectionBuilder extends FormBuilderAbstract
{
    /**
     * Create a new FormBuilderAbstract instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui)
    {
        parent::__construct($ui);

        $this->assignments = $this->ui->getModel()->getStream()->assignments;
    }

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $title  = $this->buildTitle();
        $fields = $this->buildFields();

        return compact('title', 'fields');
    }

    /**
     * Return the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        return trans(evaluate_key($this->options, 'title', null, [$this->ui]));
    }

    /**
     * Build the fields.
     *
     * @return array
     */
    protected function buildFields()
    {
        $fields = [];

        foreach (evaluate_key($this->options, 'fields', []) as $field) {
            $fields[] = $this->assignments->findByFieldSlug($field);
        }

        return $fields;
    }
}
