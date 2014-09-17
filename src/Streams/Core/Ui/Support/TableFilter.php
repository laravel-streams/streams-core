<?php namespace Streams\Core\Ui\Support;

use Streams\Core\Ui\TableUi;
use Streams\Core\Ui\Contract\TableFilterInterface;

class TableFilter implements TableFilterInterface
{
    /**
     * The filter options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * The UI object.
     *
     * @var \Streams\Core\Ui\TableUi
     */
    protected $ui;

    /**
     * Create a new TableFilterAbstract instance.
     *
     * @param TableUi $ui
     * @param         $options
     */
    public function __construct(TableUi $ui, $options)
    {
        $this->ui = $ui;

        $this->options = $options;
    }

    /**
     * Return the filter input.
     *
     * @return null|string
     */
    public function input()
    {
        switch ($this->getOption('type')) {
            case 'select':
                return $this->buildSelectFilterInput();
                break;

            case 'text':
            case 'email':
                return $this->buildTextFilterInput();
                break;

            default:
                break;
        }

        return null;
    }

    /**
     * Return the input for a generic select filter input.
     *
     * @return mixed
     */
    protected function buildSelectFilterInput()
    {
        return \Form::select(
            $this->getOption('slug'),
            $this->getOption('options'),
            $this->getValue(),
            [
                'class' => 'form-control'
            ]
        );
    }

    /**
     * Return the input for a generic text filter input.
     *
     * @return mixed
     */
    protected function buildTextFilterInput()
    {
        return \Form::input(
            $this->getOption('type'),
            $this->getOption('name'),
            $this->getValue(),
            [
                'placeholder' => trans($this->getOption('placeholder', humanize($this->getOption('name')))),
                'class'       => 'form-control'
            ]
        );
    }

    /**
     * Return the current value of the filter.
     *
     * @return mixed
     */
    public function getValue()
    {
        $value = null;

        switch ($this->getOption('type')) {
            case 'field':

            default:
                $value = \Input::get($this->getOption('name'));
                break;
        }

        return $value;
    }

    /**
     * Build onto the query.
     *
     * @param $query
     * @return null
     */
    public function query($query)
    {
        switch ($this->getOption('type')) {
            case 'field':

            default:
                $query = evaluate($this->getOption('query'), [$query, $this]);
                break;
        }

        return $query;
    }

    /**
     * Return an option value.
     *
     * @param      $option
     * @param null $default
     * @return mixed
     */
    public function getOption($option, $default = null)
    {
        return isset($this->options[$option]) ? $this->options[$option] : $default;
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}