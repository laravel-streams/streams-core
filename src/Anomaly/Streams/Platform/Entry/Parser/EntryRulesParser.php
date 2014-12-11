<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;

/**
 * Class EntryRulesParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryRulesParser
{
    /**
     * Return the entry validation rules.
     *
     * @param StreamModel $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $string = '[';

        foreach ($stream->getAssignments() as $assignment) {
            $this->parseAssignmentRules($stream, $assignment, $string);
        }

        $string .= "\n]";

        return $string;
    }

    /**
     * Parse the assignment rules.
     *
     * @param StreamInterface     $stream
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected function parseAssignmentRules(StreamInterface $stream, AssignmentInterface $assignment, &$string)
    {
        $rules = [];

        $field = $assignment->getField();

        if ($fieldRules = $field->getRules()) {
            foreach ($fieldRules as $rule) {
                $rules[] = $rule;
            }
        }

        if ($assignment->isRequired()) {
            $rules[] = 'required';
        }

        if ($assignment->isUnique()) {
            $rules[] = 'unique:' . $stream->getEntryTableName() . ',' . $assignment->getColumnName();
        }

        if (is_array($rules)) {
            $rules = implode('|', array_filter($rules));

            $string .= "\n'{$assignment->getFieldSlug()}' => '{$rules}',";
        }
    }
}
