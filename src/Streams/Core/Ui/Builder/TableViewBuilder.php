<?php namespace Streams\Core\Ui\Builder;

use Streams\Core\Ui\Contract\TableViewInterface;

class TableViewBuilder extends TableBuilderAbstract
{
    /**
     * The view object.
     *
     * @var null
     */
    protected $view = null;

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $url   = $this->buildUrl();
        $title = $this->buildTitle();
        $class = $this->buildClass();

        return compact('title', 'class', 'url');
    }

    /**
     * Return the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        return trans(evaluate($this->view->getOption('title'), null, [$this->ui]));
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        $class = evaluate($this->view->getOption('class'), '', [$this->ui]);

        if ($this->view->isActive()) {
            $class .= ' active';
        }

        return $class;
    }

    /**
     * Return the URL.
     *
     * @return string
     */
    protected function buildUrl()
    {
        return \Request::url() . '?view=' . $this->view->getSlug();
    }

    /**
     * Set the view.
     *
     * @param TableViewInterface $view
     * @return $this
     */
    public function setView(TableViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }
}
