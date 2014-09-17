<?php namespace Streams\Core\Ui\Builder;

class TableHeaderBuilder extends TableBuilderAbstract
{
    /**
     * Create a new TableHeaderBuilder instance.
     *
     * @param \Streams\Core\Ui\TableUi $ui
     */
    public function __construct($ui)
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
        $title = $this->buildTitle();

        return compact('title');
    }

    /**
     * Return the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        $title = evaluate_key($this->options, 'title', null, [$this->ui]);

        if ($assignment = $this->assignments->findByFieldSlug($title)) {
            $title = $assignment->field->name;
        } else {
            $translated = trans($title);

            if ($translated == $title) {
                $title = humanize($title);
            } else {
                $title = $translated;
            }
        }

        return $title;
    }

    /**
     * Make the class and catch defaults.
     *
     * @param $options
     * @return $this
     */
    public function make($options)
    {
        if (is_string($options)) {
            $options = [
                'title' => $options,
            ];
        }

        return parent::make($options);
    }
}
