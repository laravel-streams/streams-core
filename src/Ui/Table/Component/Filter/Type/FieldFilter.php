<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\FieldFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Query\FieldFilterQuery;

/**
 * Class FieldFilter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type
 */
class FieldFilter extends Filter implements FieldFilterInterface
{

    /**
     * The filter query.
     *
     * @var string
     */
    protected $query = FieldFilterQuery::class;

    /**
     * The filter field.
     *
     * @var string
     */
    protected $field;

    /**
     * The stream object.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Get the input HTML.
     *
     * @return \Illuminate\View\View
     */
    public function getInput()
    {
        $field = $this->stream->getField($this->getField());

        $type = $field->getType();

        $type->setLocale(null);
        $type->setValue($this->getValue());
        $type->setPrefix($this->getPrefix() . 'filter_');
        $type->setPlaceholder($this->getPlaceholder());

        return $type->getFilter();
    }

    /**
     * Set the filter field.
     *
     * @param  $field
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
     * Set the stream.
     *
     * @param  StreamInterface $stream
     * @return $this
     */
    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }
}
