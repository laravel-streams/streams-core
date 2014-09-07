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

        return compact('sections');
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
}
