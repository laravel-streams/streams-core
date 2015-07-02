<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Filter;

/**
 * Class InputFilter
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Filter\Type
 */
class InputFilter extends Filter
{

    /**
     * The input type.
     *
     * @var string
     */
    protected $type;

    /**
     * Get the input HTML.
     *
     * @return string
     */
    public function getInput()
    {
        return app('form')->input(
            $this->getType(),
            $this->getInputName(),
            $this->getValue(),
            [
                'class'       => 'form-control',
                'placeholder' => trans($this->getPlaceholder() ?: $this->getSlug())
            ]
        );
    }

    /**
     * Get the input type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the input type.
     *
     * @param  $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
