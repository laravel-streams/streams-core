<?php

namespace Anomaly\Streams\Platform\Ui\Tree\Component\Button;

use Anomaly\Streams\Platform\Support\Parser;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class ButtonParser.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Tree\Component\Button
 */
class ButtonParser
{
    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Create a new ButtonParser instance.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the button with the entry.
     *
     * @param array $button
     * @param       $entry
     */
    public function parse(array $button, $entry)
    {
        /* @var Arrayable $entry */
        $entry = $entry->toArray();

        return $this->parser->parse($button, compact('entry'));
    }
}
