<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\Contract\HeaderInterface;
use Anomaly\Streams\Platform\Ui\Table\Table;

/**
 * Class HeaderHeading
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header
 */
class HeaderHeading
{

    /**
     * Return the header header text.
     *
     * @param Table           $table
     * @param HeaderInterface $heading
     * @return null|string
     */
    public function make(Table $table, HeaderInterface $heading)
    {
        $heading = $heading->getHeading();

        $stream = $table->getStream();

        /**
         * If the header is null then the intent was
         * to not have header text at all.
         */
        if ($heading === null) {
            return null;
        }

        /**
         * If the header is a closure then return
         * the value from it.
         */
        if ($heading instanceof \Closure) {
            return app()->call($heading, compact('table'));
        }

        /**
         * If the table is using streams try getting
         * the name from the field for the header.
         */
        if (is_string($heading) && $stream instanceof StreamInterface) {

            $field = explode('.', $heading);

            if ($field[0] == 'entry') {
                array_shift($field);
            }

            $field = array_shift($field);

            if ($field = $stream->getField($field)) {
                return trans($field->getName());
            }
        }

        return trans($heading);
    }
}
