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

        $request = app('request');

        $repository = $this->newRepository();

        if ($request->is('post')) {

            return $this->newFormRequest();

        }

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
    public function setActions(array $actions)
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
    public function setSections(array $sections)
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
    public function setSkips(array $skips)
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
     * @param string $view
     * return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
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
    protected function newRepository()
    {
        return new FormRepository($this, $this->model);
    }

    /**
     * @return FormRequest
     */
    protected function newFormRequest()
    {
        return new FormRequest($this);
    }
}
 