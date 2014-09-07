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

        foreach ($sections as $section) {
            $title = trans(\ArrayHelper::value($section, 'title', null, [$this->ui]));

            $section = compact('title');
        }

        return $sections;
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
            $url = \ArrayHelper::value($action, 'url', '#', [$this->ui]);

            $title = trans(\ArrayHelper::value($action, 'title', null, [$this->ui]));

            $attributes = \ArrayHelper::value($action, 'attributes', [], [$this->ui]);

            $button = \HTML::link($url, $title, $attributes);

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
