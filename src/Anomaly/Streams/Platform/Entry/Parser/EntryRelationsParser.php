<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Parser;

/**
 * Class EntryRelationsParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryRelationsParser extends Parser
{

    /**
     * Parse the relation methods.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $string = '';

        $assignments = $stream->getAssignments();

        foreach ($assignments->relations() as $assignment) {

            $this->parseAssignment($assignment, $string);
        }

        return $string;
    }

    /**
     * Parse an assignment relation.
     *
     * @param AssignmentInterface $assignment
     * @param                     $string
     */
    protected function parseAssignment(AssignmentInterface $assignment, &$string)
    {
        $fieldSlug = $assignment->getFieldSlug();

        $method = camel_case($fieldSlug);

        $relationString = '';

        $relationString .= "\n{$this->s(4)}public function {$method}()";

        $relationString .= "\n{$this->s(4)}{";

        $relationString .= "\n\n{$this->s(8)}return \$this->getFieldType('{$fieldSlug}')->getRelation(\$this);";

        $relationString .= "\n{$this->s(4)}}";

        $relationString .= "\n";

        $string .= $relationString;
    }
}
 