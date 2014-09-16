<?php namespace Streams\Core\Ui\Builder;

use Streams\Core\Ui\TableUi;

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
        $data  = $this->buildData();

        return compact('class', 'data');
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
    protected function buildData()
    {
        if (is_string($this->options)) {
            $this->options = [
                'data' => $this->options
            ];
        }

        $data = evaluate_key($this->options, 'data', null, [$this->ui, $this->entry]);

        if (isset($this->entry->{$data})) {
            $data = $this->entry->{$data};
        } elseif (strpos($data, '{') !== false) {
            $data = merge($data, $this->entry);
        } elseif (strpos($data, '.') !== false and $data = $this->entry) {
            foreach (explode('.', $data) as $attribute) {
                $data = $data->{$attribute};
            }
        }

        return $data;
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
                'data' => $options,
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
