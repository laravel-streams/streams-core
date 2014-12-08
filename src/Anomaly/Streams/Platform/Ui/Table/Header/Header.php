<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

class Header implements HeaderInterface
{

    protected $stream = null;

    protected $text;

    function __construct($text = null)
    {
        $this->text = $text;
    }

    public function viewData()
    {
        $text = $this->getText();

        if ($this->stream and is_string($text)) {

            $text = $this->getTextFromField($text);
        }

        $text = trans($text);

        return compact('text');
    }

    public function setStream(StreamInterface $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    protected function getTextFromField($text)
    {
        if ($field = $this->stream->getField($text)) {

            return $field->getName();
        }

        return $text;
    }
}
 