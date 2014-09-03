<?php namespace Streams\Core\Ui\Component;

class FormTabHeading extends FormComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The title of the section.
     *
     * @var null
     */
    protected $title = null;

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $title = $this->buildTitle();

        return \View::make($this->view ?: 'streams/partials/form/tab_heading', compact('title'));
    }

    /**
     * Build the title of the section.
     *
     * @return mixed
     */
    protected function buildTitle()
    {
        $title = \StreamsHelper::value($this->title, [$this]);

        return \Lang::trans($title);
    }

    /**
     * Set the section title.
     *
     * @param null $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
