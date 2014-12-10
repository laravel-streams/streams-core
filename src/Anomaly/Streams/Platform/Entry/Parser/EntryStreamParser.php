<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryStreamParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryStreamParser
{

    /**
     * Parse the stream data.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $string = '[';

        $this->parseStream($stream, $string);
        $this->parseAssignments($stream, $string);

        $string .= "\n]";

        return $string;
    }

    /**
     * Parse the stream.
     *
     * @param StreamInterface $stream
     * @param                 $string
     */
    protected function parseStream(StreamInterface $stream, &$string)
    {
        foreach ($stream->getAttributes() as $key => $value) {

            $string .= "\n'{$key}' => {$value},";
        }
    }

    /**
     * Parse the assignments.
     *
     * @param StreamInterface $stream
     * @param                 $string
     */
    protected function parseAssignments(StreamInterface $stream, &$string)
    {
        $string .= "\n'assignments' => [";

        foreach ($stream->getAssignments() as $assignment) {

            $this->parseAssignment($assignment, $string);
        }

        $string .= "\n],";
    }

    /**
     * Parse an assignment.
     *
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected function parseAssignment(AssignmentInterface $assignment, &$string)
    {
        $string .= "\n[";

        foreach ($assignment->getAttributes() as $key => $value) {

            $value = $assignment->getAttribute($key);

            $string .= "\n'{$key}' => {$value},";
        }

        // Parse this assignment field.
        $this->parseField($assignment->getField(), $string);

        $string .= "\n],";
    }

    /**
     * Parse an assignment field.
     *
     * @param FieldInterface $field
     * @param                $string
     */
    protected function parseField(FieldInterface $field, &$string)
    {
        $string .= "\n'field' => [";

        foreach ($field->getAttributes() as $key => $value) {

            $value = $field->getAttribute($key);

            if (is_array($value)) {

                $value = serialize($value);
            }

            $string .= "\n'{$key}' => {$value},";
        }

        $string .= "\n],";
    }
}
 