<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FieldFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

class FieldFilter extends Filter implements FieldFilterInterface
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
        $field = $this->stream->getField($this->getField());

        $type = $field->getType();

        $type->setPrefix($this->getPrefix());
        $type->setValue($this->getValue());
        $type->setPlaceholder($this->getPlaceholder() ? trans($this->getPlaceholder()) : trans($field->getName()));

        return $type->renderFilter();
    }

    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getStream()
    {
        return $this->stream;
    }
}
 