<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Guesser;

use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeadingGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Button\Guesser
 */
class HeadingGuesser
{

    /**
     * Guess the field for a column.
     *
     * @param array $header
     */
    public function guess(array &$header, TableBuilder $builder)
    {
        /**
         * If the header is false then the intent was
         * to not have header text at all.
         */
        if ($header['heading'] === false) {
            return;
        }

        $stream = $builder->getTableStream();

        /**
         * No stream means we can't
         * really do much here.
         */
        if (!$stream instanceof StreamInterface) {
            return;
        }

        $field = $stream->getField($header['heading']);

        /**
         * No field means we still do not have
         * anything to do here.
         */
        if (!$field instanceof FieldInterface) {
            return;
        }

        if ($name = $field->getName()) {
            $header['heading'] = $name;
        }
    }
}
