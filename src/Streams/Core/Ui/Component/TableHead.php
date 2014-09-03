<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\Contract\RenderableInterface;

class TableHead extends TableComponent
{
    /**
     * The view to use.
     *
     * @var string
     */
    protected $view = 'streams/partials/table/head';

    /**
     * Return the output.
     *
     * @return string|void
     */
    public function render()
    {
        $headers = $this->buildHeaders();

        return \View::make($this->view, compact('headers'));
    }

    /**
     * Return a collection of TableHeader components.
     *
     * @return \Streams\Ui\Collection\TableHeaderCollection
     */
    protected function buildHeaders()
    {
        $headers = [];

        foreach ($this->ui->getColumns() as $options) {

            if (isset($options['header']) and $options['header'] instanceof RenderableInterface) {
                continue;
            }

            if (is_string($options)) {
                $options = ['field' => $options];
            }

            $header = $this->ui->newTableHeader();

            if (isset($options['view'])) {
                $header = $header->setView($options['view']);
            }

            if (isset($options['field'])) {
                $header = $header->setField($options['field']);
            }

            if (isset($options['header'])) {
                $header = $header->setHeader($options['header']);
            }

            if (isset($options['attributes'])) {
                $header = $header->setAttributes($options['attributes']);
            }

            $headers[] = compact('header');
        }

        return $this->ui->newTableHeaderCollection($headers);
    }
}
