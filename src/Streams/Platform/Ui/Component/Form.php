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
        $this->actionBuilder  = $this->ui->newActionBuilder($ui);
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
     * Return the actions for the form.
     *
     * @return null
     */
    protected function makeActions()
    {
        $actions = [];

        foreach ($this->ui->actions() as $action) {
            $actions[] = $this->actionBuilder->setAction($action)->data();
        }

        return $actions;
    }
}
