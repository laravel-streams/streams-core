<?php namespace Streams\Platform\Ui\Builder;

use Streams\Platform\Ui\TableUi;

class TableColumnBuilder extends TableBuilderAbstract
{
    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $class = $this->buildClass();
        $value = $this->buildValue();

        return compact('class', 'value');
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        return evaluate_key($this->options, 'class', null, [$this->ui, $this->entry]);
    }

    /**
     * Return the column data.
     *
     * @return string
     */
    protected function buildValue()
    {
        $value = evaluate_key($this->options, 'value', null, [$this->ui, $this->entry]);

        if (isset($this->entry->{$value})) {
            $value = $this->entry->{$value};
        } elseif (strpos($value, '{') !== false) {
            $value = merge($value, $this->entry);
        } elseif (strpos($value, '.') !== false and $value = $this->entry) {
            foreach (explode('.', $value) as $attribute) {
                $value = $value->{$attribute};
            }
        }

        return $value;
    }

    /**
     * Set the options and catch defaults.
     *
     * @param $options
     * @return $this
     */
    public function setOptions($options)
    {
        if (is_string($options)) {
            $options = [
                'value' => $options,
            ];
        }

        return parent::setOptions($options);
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
