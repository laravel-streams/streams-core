<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;

class Header implements HeaderInterface
{

    protected $text;

    protected $prefix;

    function __construct($text = null, $prefix = null)
    {
        $this->text   = $text;
        $this->prefix = $prefix;
    }

    public function viewData()
    {
        $text = 'Header!';

        return compact('text');
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
 