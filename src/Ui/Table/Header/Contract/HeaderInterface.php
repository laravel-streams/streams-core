<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Contract;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Interface HeaderInterface
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Contract
 */
interface HeaderInterface
{

    /**
     * Return the view data.
     *
     * @param array $arguments
     * @return mixed
     */
    public function getTableData();

    /**
     * Set the stream object.
     *
     * @param StreamInterface $stream
     * @return mixed
     */
    public function setStream(StreamInterface $stream);

    /**
     * Set the text.
     *
     * @param $text
     * @return mixed
     */
    public function setText($text);

    /**
     * Get the text.
     *
     * @return mixed
     */
    public function getText();
}
