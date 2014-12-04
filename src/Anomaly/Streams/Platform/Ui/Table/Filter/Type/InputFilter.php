<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;

class InputFilter extends Filter
{

    protected $type;

    function __construct($slug, $type = 'text', $prefix = null, $handler = null, $placeholder = null)
    {
        $this->type = $type;

        parent::__construct($slug, $prefix, $handler, $placeholder);
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    protected function getInput()
    {
        $class       = 'form-control';
        $placeholder = trans($this->getPlaceholder());

        $options = compact('class', 'placeholder');

        return app('form')->input($this->getType(), $this->getName(), $this->getValue(), $options);
    }
}
 