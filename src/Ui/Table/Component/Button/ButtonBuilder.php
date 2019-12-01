<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class ButtonBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
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
     * The button value utility.
     *
     * @var ButtonValue
     */
    protected $value;

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
     * @param ButtonInput $input
     * @param ButtonValue $value
     * @param ButtonFactory $factory
     * @param Evaluator $evaluator
     */
    public function __construct(
        ButtonInput $input,
        ButtonValue $value,
        ButtonFactory $factory,
        Evaluator $evaluator
    ) {
        $this->input     = $input;
        $this->value     = $value;
        $this->factory   = $factory;
        $this->evaluator = $evaluator;
    }

    /**
     * Build the buttons.
     *
     * @param  TableBuilder $builder
     * @param                   $entry
     * @return ButtonCollection
     */
    public function build(TableBuilder $builder, $entry)
    {
        $table = $builder->getTable();

        $buttons = new ButtonCollection();

        $this->input->read($builder);

        foreach ($builder->getButtons() as $button) {

            array_set($button, 'entry', $entry);

            $button = evaluate($button, compact('entry', 'builder'));
            $button = parse($button, compact('entry'));
            $button = $this->value->replace($button, $entry);
            $button = $this->factory->make($button);

            if (!$button->isEnabled()) {
                continue;
            }

            $buttons->push($button);
        }

        return $buttons;
    }
}
