<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\FieldFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FieldFilter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Type
 */
class FieldFilter extends Filter implements FieldFilterInterface
{

    /**
     * The filter field.
     *
     * @var null
     */
    protected $field;

    /**
     * The stream object.
     *
     * @var \Anomaly\Streams\Platform\Stream\Contract\StreamInterface
     */
    protected $stream;

    /**
     * Hook into the table query.
     *
     * @param Table   $table
     * @param Builder $query
     */
    public function onTableQuerying(Table $table, Builder $query)
    {
        $type = $this->stream->getFieldType($this->field);

        $type->filter($query, $this->getValue());
    }

    /**
     * Get the input HTML.
     *
     * @return \Illuminate\View\View
     */
    protected function getInput()
    {
        $field = $this->stream->getField($this->getField());

        $type = $field->getType();

        $type->setPrefix($this->getPrefix());
        $type->setValue($this->getValue());
        $type->setPlaceholder($this->getPlaceholder() ? trans($this->getPlaceholder()) : trans($field->getName()));

        return $type->renderFilter();
    }

    /**
     * Set the filter field.
     *
     * @param $field
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Get the filter field.
     *
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Get the stream object.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
