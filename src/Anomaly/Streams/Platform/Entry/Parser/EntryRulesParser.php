<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\StreamModel;

class EntryRulesParser
{

    public function parse(StreamModel $stream)
    {
        $string = '[';

        foreach ($stream->assignments as $assignment) {

            $rules = [];

            if ($assignment->field->rules) {

                foreach ($assignment->field->rules as $rule) {

                    $rules[] = $rule;
                }
            }

            if ($assignment->is_required) {

                $rules[] = 'required';
            }

            if (is_array($rules)) {

                $rules = implode('|', array_filter($rules));

                $string .= "\n{$this->s(8)}'{$assignment->field->slug}' => '{$rules}',";
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
 