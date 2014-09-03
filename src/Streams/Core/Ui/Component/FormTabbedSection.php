<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\Contract\RenderableInterface;
use Streams\Core\Ui\FormUi;

class FormTabbedSection extends FormComponent
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
     * The tabs array.
     *
     * @var array
     */
    protected $tabs = [];

    /**
     * Create a new FormTabContent instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;

        $this->formTabHeading = $ui->newFormTabHeading();
        $this->formTabContent = $ui->newFormTabContent();
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $tabs = $this->buildTabs();

        return \View::make($this->view ? : 'streams/partials/form/tabs', compact('tabs'));
    }

    /**
     * Build the tabs.
     *
     * @return string
     */
    protected function buildTabs()
    {
        $tabs = $this->tabs;

        if ($tabs instanceof \Closure) {
            $tabs = \StreamsHelper::value($tabs, [$this]);
        }

        foreach ($tabs as &$options) {
            $heading = $this->buildTabHeading($options);
            $content = $this->buildTabContent($options);

            $options = compact('heading', 'content');
        }

        return $this->ui->newFormTabCollection($tabs);
    }

    /**
     * Build a new tab heading instance.
     *
     * @param $options
     * @return mixed
     */
    protected function buildTabHeading($options)
    {
        if (isset($options['heading']) and $options['heading'] instanceof RenderableInterface) {
            return $options['heading'];
        }

        $heading = clone($this->formTabHeading);

        $heading->setTitle(\ArrayHelper::value($options, 'title', null, [$this]));

        return $heading;
    }

    /**
     * Build a new tab content instance.
     *
     * @param $options
     * @return mixed
     */
    protected function buildTabContent($options)
    {
        if (isset($options['content']) and $options['content'] instanceof RenderableInterface) {
            return $options['content'];
        }

        $content = clone($this->formTabContent);

        if (isset($options['layout'])) {
            $content = $content->setLayout($options['layout']);
        } elseif (isset($options['columns'])) {
            $content = $content->setLayout(
                [
                    [
                        'columns' => $options['columns']
                    ]
                ]
            );
        } elseif (isset($options['fields'])) {
            $content = $content->setLayout(
                [
                    [
                        'columns' => [
                            [
                                'fields' => $options['fields']
                            ]
                        ]
                    ]
                ]
            );
        }

        return $content;
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

    /**
     * Set the tabs array.
     *
     * @param array $tabs
     * @return $this
     */
    public function setTabs($tabs)
    {
        $this->tabs = $tabs;

        return $this;
    }
}
