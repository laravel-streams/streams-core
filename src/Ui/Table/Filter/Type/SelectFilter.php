<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Filter\Contract\SelectFilterInterface;
use Anomaly\Streams\Platform\Ui\Table\Filter\Filter;

/**
 * Class SelectFilter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Filter\Type
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
     * Create a new SelectFilter instance.
     *
     * @param       $slug
     * @param null  $prefix
     * @param bool  $active
     * @param null  $handler
     * @param null  $placeholder
     * @param array $options
     */
    public function __construct(
        $slug,
        $prefix = null,
        $active = false,
        $handler = null,
        $placeholder = null,
        $options = []
    ) {
        $this->options = $options;

        parent::__construct($slug, $active, $handler, $placeholder, $prefix);
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
     * Get the input HTML.
     *
     * @return mixed
     */
    protected function getInput()
    {
        $class = 'form-control';

        $options = compact('class');

        $list = [null => trans($this->getPlaceholder())] + $this->getOptions();

        return app('form')->select($this->getName(), $list, $this->getValue(), $options);
    }
}
