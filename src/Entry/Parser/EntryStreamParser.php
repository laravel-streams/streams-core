<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Parser;

/**
 * Class EntryStreamParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryStreamParser extends Parser
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

        $string .= "\n{$this->s(4)}]";

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

            $value = $this->toString($value, in_array($key, ['name', 'description']));

            $string .= "\n{$this->s(8)}'{$key}' => {$value},";
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
        $string .= "\n{$this->s(8)}'assignments' => [";

        foreach ($stream->getAssignments() as $assignment) {

            $this->parseAssignment($assignment, $string);
        }

        $string .= "\n{$this->s(8)}],";
    }

    /**
     * Parse an assignment.
     *
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected function parseAssignment(AssignmentInterface $assignment, &$string)
    {
        $string .= "\n{$this->s(12)}[";

        foreach ($assignment->getAttributes() as $key => $value) {

            $value = $this->toString($assignment->getAttribute($key), in_array($key, ['instructions']));

            $string .= "\n{$this->s(16)}'{$key}' => {$value},";
        }

        // Parse this assignment field.
        $this->parseField($assignment->getField(), $string);

        $string .= "\n{$this->s(12)}],";
    }

    /**
     * Parse an assignment field.
     *
     * @param FieldInterface $field
     * @param                $string
     */
    protected function parseField(FieldInterface $field, &$string)
    {
        $string .= "\n{$this->s(16)}'field' => [";

        foreach ($field->getAttributes() as $key => $value) {

            $value = $this->toString($field->getAttribute($key), in_array($key, ['field_name']));

            $string .= "\n{$this->s(20)}'{$key}' => {$value},";
        }

        $string .= "\n{$this->s(16)}],";
    }
}
 