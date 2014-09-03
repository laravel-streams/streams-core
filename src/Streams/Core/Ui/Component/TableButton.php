<?php namespace Streams\Core\Ui\Component;

class TableButton extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = null;

    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The attributes option.
     *
     * @var null
     */
    protected $attributes = null;

    /**
     * The title of the button.
     *
     * @var null
     */
    protected $title = null;

    /**
     * The default class string.
     *
     * @var string
     */
    protected $class = 'btn btn-xs';

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        $title      = $this->title();
        $attributes = $this->attributes();

        return \View::make($this->view ?: 'streams/partials/table/button', compact('title', 'attributes'));
    }

    /**
     * Return the button title.
     *
     * @return string
     */
    protected function title()
    {
        return \Lang::trans($this->title);
    }

    /**
     * Return the attributes array prepped for Lexicon.
     *
     * @return array
     */
    protected function attributes()
    {
        $attributes = $this->attributes;

        if ($attributes instanceof \Closure) {
            $attributes = \StreamsHelper::value($attributes, [$this]);
        }

        foreach ($attributes as $attribute => &$value) {

            $value = \StreamsHelper::value($value, [$this]);

            $value = str_replace('+', $this->class, $value);

            $attributes[$attribute] = compact('attribute', 'value');
        }

        return $attributes;
    }

    /**
     * Set the view option.
     *
     * @param $view
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the entry object.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry object.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Set the attributes option.
     *
     * @param $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * Set the button title.
     *
     * @param $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
