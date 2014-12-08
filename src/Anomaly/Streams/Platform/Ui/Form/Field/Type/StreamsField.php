<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Type;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Field\Contract\FieldInterface;

class StreamsField implements FieldInterface
{

    protected $field;

    protected $entry;

    protected $stream;

    function __construct($field, StreamInterface $stream, EntryInterface $entry = null)
    {
        $this->field  = $field;
        $this->entry  = $entry;
        $this->stream = $stream;
    }

    public function viewData()
    {
        $assignment = $this->stream->getAssignment($this->field);

        $type = $assignment->getFieldType($this->entry);

        $input = $type->render();

        return compact('input');
    }

    public function getSlug()
    {
        return $this->field;
    }
}
 