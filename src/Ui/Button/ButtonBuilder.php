<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Button
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
     * Load buttons onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        foreach ($builder->getButtons() as $key => $parameters) {

            $parameters = $this->interpreter->standardize($key, $parameters);

            $button = $this->factory->make($parameters);

            $buttons->push($button);
        }
    }
}
