<?php

namespace Anomaly\Streams\Platform\Ui\Grid\Component\Button;

use Anomaly\Streams\Platform\Support\Facades\Evaluator;
use Anomaly\Streams\Platform\Ui\Button\ButtonCollection;
use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Grid\GridBuilder;

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
     * The button parser.
     *
     * @var ButtonParser
     */
    protected $parser;

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
     * @param ButtonParser  $parser
     * @param ButtonFactory $factory
     * @param Evaluator     $evaluator
     */
    public function __construct(ButtonInput $input, ButtonParser $parser, ButtonFactory $factory)
    {
        $this->input     = $input;
        $this->parser    = $parser;
        $this->factory   = $factory;
    }

    /**
     * Build the buttons.
     *
     * @param  GridBuilder      $builder
     * @param                   $entry
     * @return ButtonCollection
     */
    public function build(GridBuilder $builder, $entry)
    {
        $grid = $builder->grid;

        $buttons = new ButtonCollection();

        $this->input->read($builder, $entry);

        foreach ($builder->buttons as $button) {
            if (!array_get($button, 'enabled', true)) {
                continue;
            }

            $button = Evaluator::evaluate($button, compact('entry', 'grid'));
            $button = $this->parser->parser($button, $entry);

            $button = $this->factory->make($button);

            $buttons->push($button);
        }

        return $buttons;
    }
}
