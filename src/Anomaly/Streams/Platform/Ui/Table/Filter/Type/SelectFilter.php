<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\SelectFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;

class SelectFilter extends Filter implements SelectFilterInterface
{
    protected $options;

    public function __construct($slug, array $options, $prefix = null, $active = false, $handler = null, $placeholder = null)
    {
        $this->options = $options;

        parent::__construct($slug, $prefix, $active, $handler, $placeholder);
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    protected function getInput()
    {
        $class = 'form-control';

        $options = compact('class');

        $list = [null => trans($this->getPlaceholder())] + $this->getOptions();

        return app('form')->select($this->getName(), $list, $this->getValue(), $options);
    }
}
