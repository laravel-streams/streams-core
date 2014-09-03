<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\Contract\RenderableInterface;
use Streams\Core\Ui\FormUi;

class Form extends FormComponent
{
    /**
     * The table view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * Create a new FormColumn instance.
     *
     * @param FormUi $ui
     */
    public function __construct(FormUi $ui = null)
    {
        $this->ui = $ui;

        $this->formSection       = $ui->newFormSection();
        $this->formTabbedSection = $ui->newFormTabbedSection();
    }

    /**
     * Render the table.
     *
     * @return string
     */
    public function render()
    {
        $sections = $this->buildSections();

        return \View::make($this->view ? : 'streams/form', compact('sections'));
    }

    /**
     * Build the sections array.
     *
     * @return string
     */
    protected function buildSections()
    {
        $sections = $this->ui->getSections();

        if ($sections instanceof \Closure) {
            $sections = \StreamsHelper::value($sections, [$this]);
        }

        foreach ($sections as &$options) {

            if ($options instanceof RenderableInterface) {
                $options = ['section' => $options];
                continue;
            }

            if (isset($options['tabs'])) {
                $section = $this->buildTabbedSection($options);
            } else {
                $section = $this->buildSection($options);
            }

            $section->setTitle(\ArrayHelper::value($options, 'title', null, [$this]));

            $options = compact('section');
        }

        return $sections;
    }

    /**
     * Build a new tabbed form section.
     *
     * @param array $options
     * @return mixed
     */
    protected function buildTabbedSection($options = [])
    {
        $section = $this->formTabbedSection;

        $section = $section->setTabs(\ArrayHelper::value($options, 'tabs'));

        return $section;
    }

    /**
     * Build a new form section.
     *
     * @param array $options
     * @return mixed
     */
    protected function buildSection($options = [])
    {
        $section = $this->formSection;

        if (isset($options['layout'])) {
            $section->setLayout(\ArrayHelper::value($options, 'layout', null, [$this]));
        } elseif (isset($options['columns'])) {
            $section->setLayout(
                [
                    [
                        'columns' => $options['columns']
                    ]
                ]
            );
        } elseif (isset($options['fields'])) {
            $section->setLayout(
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
        } else {
            $section->setLayout(
                [
                    [
                        'columns' => [
                            [
                                'fields' => $options
                            ]
                        ]
                    ]
                ]
            );
        }

        return $section;
    }
}
