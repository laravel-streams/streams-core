<?php namespace Anomaly\Streams\Platform\Support;

use StringTemplate\Engine;

/**
 * Class Parser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class Parser
{

    /**
     * The string parser.
     *
     * @var Engine
     */
    protected $parser;

    /**
     * Create a new Parser instance.
     *
     * @param Engine $parser
     */
    public function __construct(Engine $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse data into the target recursively.
     *
     * @param       $target
     * @param array $data
     * @return mixed
     */
    public function parse($target, array $data = [])
    {
        /**
         * If the target is an array
         * then parse it recursively.
         */
        if (is_array($target)) {
            foreach ($target as &$value) {
                $value = $this->parse($value, $data);
            }
        }

        /**
         * if the target is a string and is in a parsable
         * format then parse the target with the payload.
         */
        if (is_string($target) && str_contains($target, ['{', '}'])) {
            $target = $this->parser->render($target, $data);
        }

        return $target;
    }
}
