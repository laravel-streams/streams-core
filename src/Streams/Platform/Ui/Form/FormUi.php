<?php namespace Streams\Platform\Ui\Form;

use Streams\Platform\Ui\Ui;

class FormUi extends Ui
{
    /**
     * @var array
     */
    protected $skips = [];

    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * @var string
     */
    protected $view = 'html/form';

    /**
     * @return $this
     */
    public function trigger()
    {
        $this->fire('trigger');

        $repository = $this->newRepository();

        $form = $this->newFormService();

        $sections = $form->sections();
        $actions  = $form->actions();

        $data = compact('sections', 'actions');

        $this->content = view($this->view, $data);

        return $this;
    }

    /**
     * @param array $actions
     * return $this
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
        return $this;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param array $sections
     * return $this
     */
    public function setSections($sections)
    {
        $this->sections = $sections;
        return $this;
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param array $skips
     * return $this
     */
    public function setSkips($skips)
    {
        $this->skips = $skips;
        return $this;
    }

    /**
     * @return array
     */
    public function getSkips()
    {
        return $this->skips;
    }

    /**
     * @param string $title
     * return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $view
     * return $this
     */
    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return string
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param string $wrapper
     * return $this
     */
    public function setWrapper($wrapper)
    {
        $this->wrapper = $wrapper;
        return $this;
    }

    /**
     * @return string
     */
    public function getWrapper()
    {
        return $this->wrapper;
    }

    /**
     * @return FormService
     */
    protected function newFormService()
    {
        return new FormService($this);
    }

    /**
     * @return FormRepository
     */
    private function newRepository()
    {
        return new FormRepository($this, $this->model);
    }
}
 