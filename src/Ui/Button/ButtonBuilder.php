<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button
 */
class ButtonBuilder
{

    /**
     * The button interpreter.
     *
     * @var ButtonInterpreter
     */
    protected $interpreter;

    /**
     * The button factory.
     *
     * @var ButtonFactory
     */
    protected $factory;

    /**
     * Create a new ButtonBuilder instance.
     *
     * @param ButtonInterpreter $interpreter
     * @param ButtonFactory     $factory
     */
    function __construct(ButtonInterpreter $interpreter, ButtonFactory $factory)
    {
        $this->factory     = $factory;
        $this->interpreter = $interpreter;
    }

    /**
     * Build the buttons and load it onto the table.
     *
     * @param array            $buttons
     * @param ButtonCollection $collection
     */
    public function load(array $buttons, ButtonCollection $collection)
    {
        foreach ($buttons as $key => $parameters) {

            $parameters = $this->interpreter->standardize($key, $parameters);

            $button = $this->factory->make($parameters);

            $collection->push($button);
        }
    }
}
