<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

class Header implements HeaderInterface
{

    protected $text;

    protected $prefix;

    protected $stream;

    function __construct($text = null, $prefix = null, StreamInterface $stream = null)
    {
        $this->text   = $text;
        $this->prefix = $prefix;
        $this->stream = $stream;
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

    protected function getTextFromField($text)
    {
        if ($field = $this->stream->getField($text)) {

            return $field->getName();
        }

        return $text;
    }

    public function setStream(StreamInterface $stream = null)
    {
        $this->stream = $stream;

        return $this;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix()
    {
        return $this->prefix;
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
}
 