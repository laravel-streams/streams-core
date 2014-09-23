<?php namespace Streams\Platform\Ui\Builder;

class TableButtonBuilder extends TableBuilderAbstract
{
    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Pre-registered buttons.
     *
     * @var array
     */
    protected $buttons = [
        'delete'  => [
            'title' => 'button.delete',
            'class' => 'btn btn-sm btn-danger',
        ],
        'edit'    => [
            'title' => 'button.edit',
            'class' => 'btn btn-sm btn-default',
        ],
        'options' => [
            'title' => 'Options',
            'class' => 'btn btn-sm btn-link',
        ]
    ];

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $url      = $this->buildUrl();
        $title    = $this->buildTitle();
        $class    = $this->buildClass();
        $dropdown = $this->buildDropdown();

        return compact('title', 'class', 'url', 'dropdown');
    }

    /**
     * Return the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        $default = $this->defaultValue('title');

        return trans(evaluate_key($this->options, 'title', $default, [$this->ui, $this->entry]));
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        $default = $this->defaultValue('class');

        return evaluate_key($this->options, 'class', $default, [$this->ui, $this->entry]);
    }

    /**
     * Return the URL.
     *
     * @return mixed|null
     */
    protected function buildUrl()
    {
        return url(evaluate_key($this->options, 'path', null, [$this->ui, $this->entry]));
    }

    /**
     * Build the dropdown.
     *
     * @return array
     */
    protected function buildDropdown()
    {
        $dropdown = [];

        foreach (evaluate_key($this->options, 'dropdown', [], [$this->ui]) as $options) {
            $title = trans($options['title']);
            $url   = url($options['path']);

            $dropdown[] = compact('title', 'url');
        }

        return $dropdown;
    }

    /**
     * Return the pre-registered default value.
     *
     * @param      $property
     * @param null $default
     * @return null
     */
    protected function defaultValue($property, $default = null)
    {
        if (isset($this->options['type'])) {
            if (isset($this->buttons[$this->options['type']])) {
                return $this->buttons[$this->options['type']][$property];
            }
        }

        return $default;
    }

    /**
     * Set the entry.
     *
     * @param null $entry
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }
}
