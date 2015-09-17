<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Contract\SelectFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;

/**
 * Class SelectFilter.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type
 */
class SelectFilter extends Filter implements SelectFilterInterface
{
    /**
     * The filter options.
     *
     * @var array
     */
    protected $options;

    /**
     * Get the input HTML.
     *
     * @return string
     */
    public function getInput()
    {
        $class = 'form-control';

        $options = compact('class');

        return app('form')->select(
            $this->getInputName(),
            array_merge([null => trans($this->getPlaceholder())], $this->getOptions()),
            $this->getValue(),
            $options
        );
    }

    /**
     * Get the options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set the options.
     *
     * @param  array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }
}
