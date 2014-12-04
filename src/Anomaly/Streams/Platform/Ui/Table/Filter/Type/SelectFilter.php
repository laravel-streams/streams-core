<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;

class SelectFilter extends Filter
{

    protected $options;

    function __construct($slug, array $options, $prefix = null, $active = false, $handler = null, $placeholder = null)
    {
        $this->options = $options;

        parent::__construct($slug, $prefix, $active, $handler, $placeholder);
    }

    protected function getInput()
    {
        $class = 'form-control';

        $options = compact('class');

        $list = [null => trans($this->getPlaceholder())] + $this->options;

        return app('form')->select($this->getName(), $list, $this->getValue(), $options);
    }
}
 