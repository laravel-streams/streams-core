<?php

namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryRelationsParser.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Parser
 */
class EntryRelationsParser
{
    /**
     * Parse the relation methods.
     *
     * @param  StreamInterface $stream
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

        $relationString .= "\npublic function {$method}()";

        $relationString .= "\n{";

        $relationString .= "\n\nreturn \$this->getFieldType('{$fieldSlug}')->getRelation();";

        $relationString .= "\n}";

        $relationString .= "\n";

        $string .= $relationString;
    }
}
