<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Contract;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

interface HeaderInterface
{

    public function viewData();

    public function setStream(StreamInterface $stream);
}
 