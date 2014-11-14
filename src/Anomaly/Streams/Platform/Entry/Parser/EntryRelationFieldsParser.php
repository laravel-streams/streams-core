<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryRelationFieldsParser
{

    public function parse(StreamModel $stream)
    {
        $string = "[";

        foreach ($stream->assignments->relations() as $assignment) {

            $type = $assignment->type();

            $relationArray = $type->relation();

            $key = $this->toString($assignment->field->slug);

            $value = $this->toString($relationArray['method']);

            $string .= "\n{$this->s(8)}{$key} => {$value},";
        }

        $string .= "\n{$this->s(4)}]";

        return $string;
    }

    protected function toString($value, $escape = false)
    {
        if (is_null($value)) {

            $value = 'null';
        } elseif (is_bool($value)) {

            if ($value) {

                $value = 'true';
            } else {

                $value = 'false';
            }
        } elseif (!is_numeric($value) and !is_bool($value)) {

            if ($escape) {

                $value = addslashes($value);
            }

            $value = "'" . $value . "'";
        }

        return $value;
    }

    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }
}
 