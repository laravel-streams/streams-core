<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\FormUi;

class Form
{
    /**
     * The UI object.
     *
     * @var \Streams\Core\Ui\FormUi
     */
    protected $ui;

    /**
     * Create a new Form instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;
    }

    /**
     * Return the data needed to render the form.
     *
     * @return array
     */
    public function data()
    {
        $sections = $this->makeSections();
        $actions  = $this->makeActions();

        return compact('sections', 'actions');
    }

    /**
     * Return the sections for the form.
     *
     * @return null
     */
    protected function makeSections()
    {
        $sections = $this->ui->getSections();

        if ($sections === null) {
            $sections = [
                [
                    'title'  => $this->ui->getTitle(),
                    'fields' => $this->ui->getEntry()->getStream()->assignments->fieldSlugs(),
                ]
            ];
        }

        foreach ($sections as &$section) {
            $title = trans(\ArrayHelper::value($section, 'title', null, [$this->ui]));

            $rows = $this->makeRows($section);

            $section = compact('title', 'rows');
        }

        return $sections;
    }

    /**
     * Return the rows for a form section.
     *
     * @param $section
     * @return mixed
     */
    protected function makeRows($section)
    {
        $rows = \ArrayHelper::value(
            $section,
            'rows',
            [
                [
                    'columns' => \ArrayHelper::value(
                            $section,
                            'columns',
                            [
                                [
                                    'attributes' => [
                                        'class' => 'col-lg-24',
                                    ],
                                    'fields'     => \ArrayHelper::value(
                                            $section,
                                            'fields',
                                            null,
                                            [$this->ui]
                                        )
                                ]
                            ],
                            [$this->ui]
                        )
                ]
            ],
            [$this->ui]
        );

        foreach ($rows as &$row) {
            $columns = $this->makeColumns($row);

            $row = compact('columns');
        }

        return $rows;
    }

    /**
     * Return the columns for a section row.
     *
     * @param $row
     * @return mixed
     */
    protected function makeColumns($row)
    {
        $columns = \ArrayHelper::value($row, 'columns', null, [$this->ui]);

        foreach ($columns as &$column) {
            $fields = $this->makeFields($column);

            $attributes = \ArrayHelper::value($column, 'attributes', [], [$this->ui]);

            foreach ($attributes as $attribute => &$value) {
                $value = [
                    'attribute' => $attribute,
                    'value'     => $value,
                ];
            }

            $column = compact('fields', 'attributes');
        }

        return $columns;
    }

    /**
     * Return the fields for a row column.
     *
     * @param $column
     * @return mixed
     */
    protected function makeFields($column)
    {
        $fields = \ArrayHelper::value($column, 'fields', null, [$this->ui]);

        $assignments = $this->ui->getEntry()->getStream()->assignments;

        foreach ($fields as &$field) {
            $field = $assignments->findBySlug($field)->field;

            $field = compact('field');
        }

        return $fields;
    }

    /**
     * Return the actions array.
     *
     * @return string
     */
    protected function makeActions()
    {
        $actions = $this->ui->getActions();

        foreach ($actions as &$action) {
            $title = trans(\ArrayHelper::value($action, 'title', null, [$this->ui]));

            $attributes = \ArrayHelper::value($action, 'attributes', [], [$this->ui]);

            $attributes['type'] = 'submit';

            $button = \Form::button($title, $attributes);

            $dropdown = \ArrayHelper::value($action, 'dropdown', [], [$this->ui]);

            foreach ($dropdown as &$item) {
                $url = \ArrayHelper::value($item, 'url', '#', [$this->ui]);

                $title = trans(\ArrayHelper::value($item, 'title', null, [$this->ui]));

                $item = compact('url', 'title');
            }

            $action = compact('button', 'attributes', 'dropdown');
        }

        return $actions;
    }
}
