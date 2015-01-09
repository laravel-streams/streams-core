<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonBuilder
{

    /**
     * The button reader.
     *
     * @var ButtonInput
     */
    protected $input;

    /**
     * The button factory.
     *
     * @var ButtonFactory
     */
    protected $factory;

    /**
     * The evaluator utility.
     *
     * @var Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ButtonBuilder instance.
     *
     * @param ButtonInput   $input
     * @param ButtonFactory $factory
     * @param Evaluator     $evaluator
     */
    public function __construct(ButtonInput $input, ButtonFactory $factory, Evaluator $evaluator)
    {
        $this->input     = $input;
        $this->factory   = $factory;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the buttons.
     *
     * @param TableBuilder $builder
     * @param              $entry
     * @return ButtonCollection
     */
    public function build(TableBuilder $builder, $entry)
    {
        $table = $builder->getTable();

        $buttons = new ButtonCollection();

        $this->input->read($builder, $entry);

        foreach ($builder->getButtons() as $button) {

            $button = $this->evaluator->evaluate($button, compact('entry', 'table'));

            $buttons->push($this->factory->make($button));
        }

        return $buttons;
    }
}
