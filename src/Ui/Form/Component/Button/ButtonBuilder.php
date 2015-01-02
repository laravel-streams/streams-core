<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Ui\Button\ButtonFactory;
use Anomaly\Streams\Platform\Ui\Button\ButtonInput;
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
     * @var ButtonInput
     */
    protected $input;

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
     * @param UrlGuesser    $href
     * @param ButtonInput  $input
     * @param ButtonFactory $factory
     */
    public function __construct(
        UrlGuesser $href,
        ButtonInput $input,
        ButtonFactory $factory
    ) {
        $this->href    = $href;
        $this->input  = $input;
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

            $button = $this->input->read($button);

            $button['size'] = 'sm';

            $button = $this->href->guess($button);
            $button = $this->factory->make($button);

            $buttons->push($button);
        }
    }
}
