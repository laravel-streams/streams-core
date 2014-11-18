<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryRelationFieldsParser
{

    public function parse(StreamModel $stream)
    {
        $string = "[";

        foreach ($stream->assignments->relations() as $assignment) {

            $type = $assignment->type();

            $relationArray = $type->getRelation();

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

            return 'null';
        } elseif (is_bool($value)) {

            if ($value) {

                return 'true';
            } else {

                return 'false';
            }
        } elseif (is_array($value)) {

            return "'" . serialize($value) . "'";
        }

        if ($escape) {

            $value = addslashes($value);
        }

        return "'" . $value . "'";
    }

    protected function s($n)
    {
        return str_repeat("\x20", $n);
    }
}
 