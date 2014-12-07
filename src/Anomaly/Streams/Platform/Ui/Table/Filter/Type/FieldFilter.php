<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

class FieldFilter extends Filter
{

    protected $field;

    protected $stream;

    function __construct(
        $slug,
        $field,
        $prefix = null,
        $active = false,
        $handler = null,
        $placeholder = null,
        StreamInterface $stream
    ) {
        $this->field  = $field;
        $this->stream = $stream;

        parent::__construct($slug, $prefix, $active, $handler, $placeholder);
    }

    public function handle(Table $table, Builder $query)
    {
        $type = $this->stream->getFieldType($this->field);

        $type->filter($query, $this->getValue());
    }

    protected function getInput()
    {
        $field = $this->stream->getField($this->field);

        $type = $field->getType();

        $type->setPrefix($this->prefix);
        $type->setValue($this->getValue());
        $type->setPlaceholder($this->placeholder ? trans($this->placeholder) : trans($field->getName()));

        return $type->renderFilter();
    }
}
 