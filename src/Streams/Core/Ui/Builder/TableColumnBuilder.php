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
        $class  = $this->buildClass();
        $output = $this->buildOutput();

        return compact('class', 'output');
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
     * Return the output.
     *
     * @return string
     */
    protected function buildOutput()
    {
        if (is_string($this->options)) {
            $this->options = [
                'output' => $this->options
            ];
        }

        $output = evaluate_key($this->options, 'output', null, [$this->ui, $this->entry]);

        if (isset($this->entry->{$output})) {
            $output = $this->entry->{$output};
        } elseif (strpos($output, '{') !== false) {
            $output = merge($output, $this->entry);
        } elseif (strpos($output, '.') !== false and $data = $this->entry) {
            foreach (explode('.', $output) as $attribute) {
                $output = $output->{$attribute};
            }
        }

        return $output;
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
