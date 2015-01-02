<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

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

    use CommanderTrait;

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
     * Create a new ButtonBuilder instance.
     *
     * @param ButtonInput   $input
     * @param ButtonFactory $factory
     */
    public function __construct(ButtonInput $input, ButtonFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the buttons.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $buttons = $table->getButtons();

        $this->input->read($builder);

        foreach ($builder->getButtons() as $button) {
            $buttons->push($this->factory->make($button));
        }
    }
}
