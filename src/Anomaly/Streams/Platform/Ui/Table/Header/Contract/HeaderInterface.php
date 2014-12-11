<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Contract;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

interface HeaderInterface
{
    public function viewData(array $arguments = []);

    public function setStream(StreamInterface $stream);

    public function setText($text);

    public function getText();
}
