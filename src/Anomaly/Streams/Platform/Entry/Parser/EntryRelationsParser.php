<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryRelationsParser
{
    public function parse(StreamModel $stream)
    {
        $string = '';

        foreach ($this->relationFields($stream) as $assignment) {

            $type = $assignment->getType();

            $type->setStream($stream);

            $relationString = '';

            $relationArray = $type->relation();

            $method = Str::camel($assignment->field->field_slug);

            $relationMethod = $relationArray['method'];

            $relationString .= "\n{$this->s(4)}public function {$method}()";

            $relationString .= "\n{$this->s(4)}{";

            $relationString .= "\n{$this->s(8)}return \$this->{$relationMethod}(";

            foreach ($relationArray['arguments'] as &$argument) {
                $argument = $this->adjustValue($argument);
            }

            $relationString .= implode(', ', $relationArray['arguments']);

            $relationString .= ");";

            $relationString .= "\n{$this->s(4)}}";

            $relationString .= "\n";

            $string .= $relationString;
        }

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
 