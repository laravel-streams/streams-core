<?php namespace Streams\Core\Ui\Builder;

class TableViewBuilder extends TableBuilderAbstract
{
    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $title = $this->buildTitle();
        $active = $this->buildActive();

        return compact('title', 'active');
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
     * Return the active flag.
     *
     * @return bool
     */
    protected function buildActive()
    {
        return ($this->buildTitle() == 'All');
    }
}
