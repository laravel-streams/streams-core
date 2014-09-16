<?php namespace Streams\Core\Ui\Builder;

class TableHeaderBuilder extends TableBuilderAbstract
{
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
        if (is_string($this->options)) {
            return humanize($this->options);
        }

        return 'Tmp'; //trans(evaluate_key($this->options, 'title', null, [$this->ui]));
    }
}
