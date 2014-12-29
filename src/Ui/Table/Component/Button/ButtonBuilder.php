<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Button\ButtonReader;
use Anomaly\Streams\Platform\Ui\Button\Guesser\HrefGuesser;
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
     * @var ButtonReader
     */
    protected $reader;

    /**
     * The href guesser.
     *
     * @var HrefGuesser
     */
    protected $href;

    /**
     * The button factory.
     *
     * @var ButtonFactory
     */
    protected $factory;

    /**
     * Create a new ButtonBuilder instance.
     *
     * @param HrefGuesser   $href
     * @param ButtonReader  $reader
     * @param ButtonFactory $factory
     */
    public function __construct(
        HrefGuesser $href,
        ButtonReader $reader,
        ButtonFactory $factory
    ) {
        $this->href    = $href;
        $this->reader  = $reader;
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

        foreach ($builder->getButtons() as $button) {

            $button = $this->reader->standardize($button);
            $button = $this->href->guess($button);
            $button = $this->factory->make($button);

            $buttons->push($button);
        }
    }
}
