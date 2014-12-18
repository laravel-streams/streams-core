<?php namespace Anomaly\Streams\Platform\Entry\Parser;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class EntryInterfacesParser
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Entry\Parser
 */
class EntryInterfacesParser
{

    /**
     * Return the entry interfaces.
     *
     * @param  StreamInterface $stream
     * @return string
     */
    public function parse(StreamInterface $stream)
    {
        $interfaces = [];

        $this->appendTranslatableInterface($interfaces, $stream);

        if (!$interfaces) {
            return null;
        }

        return 'implements ' . implode(', ', $interfaces);
    }

    /**
     * Append the translatable interface if applicable.
     *
     * @param array           $interfaces
     * @param StreamInterface $stream
     */
    protected function appendTranslatableInterface(array &$interfaces, StreamInterface $stream)
    {
        if ($stream->isTranslatable()) {
            $interfaces[] = "\\Anomaly\\Streams\\Platform\\Contract\\TranslatableInterface";
        }
    }
}
