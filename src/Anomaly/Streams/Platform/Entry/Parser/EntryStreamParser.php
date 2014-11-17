<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryStreamParser
{

    public function parse(StreamModel $stream)
    {
        // Stream attributes array
        $string = '[';

        foreach ($stream->getAttributes() as $key => $value) {

            $value = $this->toString($value, in_array($key, ['stream_name', 'about']));

            $string .= "\n{$this->s(8)}'{$key}' => {$value},";
        }

        // Assignments array
        $string .= "\n{$this->s(8)}'assignments' => [";

        foreach ($stream->assignments as $assignment) {

            // Assignment attributes array
            $string .= "\n{$this->s(12)}[";

            foreach ($assignment->getAttributes() as $key => $value) {

                $value = $this->toString($assignment->getAttribute($key), in_array($key, ['instructions']));

                $string .= "\n{$this->s(16)}'{$key}' => {$value},";
            }

            // Field attributes array
            $string .= "\n{$this->s(16)}'field' => [";

            foreach ($assignment->field->getAttributes() as $key => $value) {

                $value = $this->toString($assignment->field->getAttribute($key), in_array($key, ['field_name']));

                $string .= "\n{$this->s(20)}'{$key}' => {$value},";
            }

            // End field attributes array
            $string .= "\n{$this->s(16)}],";

            // End assignment attributes array
            $string .= "\n{$this->s(12)}],";
        }

        // End assignments array
        $string .= "\n{$this->s(8)}],";

        // End stream attributes array
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
 