<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryTraitsParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Parser
 */
class EntryTraitsParser
{

    /**
     * Return the entry traits.
     *
     * @param StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $traits = [];

        $this->appendTranslatableTrait($traits, $stream);

        return implode("\n", $traits);
    }

    /**
     * Append the translatable trait if applicable.
     *
     * @param array           $traits
     * @param StreamInterface $stream
     */
    protected function appendTranslatableTrait(array &$traits, StreamInterface $stream)
    {
        if ($stream->isTranslatable()) {
            $traits[] = "use \\Dimsav\\Translatable\\Translatable;";
        }
    }
}
 