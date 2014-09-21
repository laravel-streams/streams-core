<?php namespace Streams\Platform\Ui\Component;

use Streams\Platform\Ui\FormUi;

class Form
{
    /**
     * The UI object.
     *
     * @var \Streams\Platform\Ui\FormUi
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

        $this->sectionBuilder = $this->ui->newSectionBuilder($ui);
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
        $sections = [];

        foreach ($this->ui->getSections() as $options) {
            $sections[] = $this->sectionBuilder->setOptions($options)->data();
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
        $rows = evaluate_key(
            $section,
            'rows',
            [
                [
                    'columns' => evaluate_key(
                            $section,
                            'columns',
                            [
                                [
                                    'attributes' => [
                                        'class' => 'col-lg-24',
                                    ],
                                    'fields'     => evaluate_key(
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
        $columns = evaluate_key($row, 'columns', null, [$this->ui]);

        foreach ($columns as &$column) {
            $fields = $this->makeFields($column);

            $attributes = evaluate_key($column, 'attributes', [], [$this->ui]);

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
        $fields = evaluate_key($column, 'fields', null, [$this->ui]);

        $assignments = $this->ui->getEntry()->getStream()->assignments;

        foreach ($fields as &$field) {
            $field = $assignments->findByFieldSlug($field)->field;

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
            $title = trans(evaluate_key($action, 'title', null, [$this->ui]));

            $attributes = evaluate_key($action, 'attributes', [], [$this->ui]);

            if (isset($attributes['url'])) {
                if (!starts_with($attributes['url'], 'http')) {
                    $attributes['url'] = url($attributes['url']);
                }

                $button = \HTML::link($attributes['url'], $title, $attributes);
            } else {
                $attributes['type'] = 'submit';

                $button = \Form::button($title, $attributes);
            }

            $dropdown = evaluate_key($action, 'dropdown', [], [$this->ui]);

            foreach ($dropdown as &$item) {
                $url = evaluate_key($item, 'url', '#', [$this->ui]);

                $title = trans(evaluate_key($item, 'title', null, [$this->ui]));

                $item = compact('url', 'title');
            }

            $action = compact('button', 'attributes', 'dropdown');
        }

        return $actions;
    }
}
