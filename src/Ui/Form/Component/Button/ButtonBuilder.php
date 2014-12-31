<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Button\ButtonReader;
use Anomaly\Streams\Platform\Ui\Button\Guesser\UrlGuesser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ButtonBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Component\Button
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
     * The url guesser.
     *
     * @var UrlGuesser
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
     * @param UrlGuesser   $href
     * @param ButtonReader  $reader
     * @param ButtonFactory $factory
     */
    public function __construct(
        UrlGuesser $href,
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
     * @param FormBuilder $builder
     */
    public function build(FormBuilder $builder)
    {
        $form    = $builder->getForm();
        $buttons = $form->getButtons();

        foreach ($builder->getButtons() as $button) {

            $button = $this->reader->standardize($button);
            $button = $this->href->guess($button);
            $button = $this->factory->make($button);

            $buttons->push($button);
        }
    }
}
