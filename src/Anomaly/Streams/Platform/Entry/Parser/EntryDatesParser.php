<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryDatesParser
{

    public function parse(StreamModel $stream)
    {
        $string = "[";

        $string .= "\n{$this->s(8)}'created_at',";
        $string .= "\n{$this->s(8)}'updated_at',";

        $types = ['date', 'datetime'];

        foreach ($stream->assignments as $assignment) {

            if ($type = $assignment->type() and in_array($type->getColumnType(), $types)) {

                $string .= "\n{$this->s(8)}'{$assignment->field->slug}',";
            }
        }

        $string .= "\n{$this->s(4)}]";

        return $string;
    }

    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }
}
 