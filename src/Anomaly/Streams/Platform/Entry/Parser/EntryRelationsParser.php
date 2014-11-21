<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryRelationsParser
{

    public function parse(StreamModel $stream)
    {
        $string = '';

        foreach ($stream->assignments->relations() as $assignment) {

            $slug = $assignment->field->slug;

            $method = camel_case($slug);

            $relationString = '';

            $relationString .= "\n{$this->s(4)}public function {$method}()";

            $relationString .= "\n{$this->s(4)}{";

            $relationString .= "\n\n{$this->s(8)}return \$this->getFieldType('{$slug}')->getRelation(\$this);";

            $relationString .= "\n{$this->s(4)}}";

            $relationString .= "\n";

            $string .= $relationString;
        }

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
 