<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button;

use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\Button\ButtonNormalizer;
use Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Contract\SectionInterface;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Support\Collection;

/**
 * Class ButtonInput
 *
 * @link          http://anomaly.is/streams-Platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Button
 */
class ButtonInput
{

    /**
     * The button guesser.
     *
     * @var ButtonGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The button normalizer.
     *
     * @var ButtonNormalizer
     */
    protected $normalizer;

    /**
     * Create a new ButtonInput instance.
     *
     * @param Resolver         $resolver
     * @param ButtonGuesser    $guesser
     * @param ButtonNormalizer $normalizer
     */
    public function __construct(Resolver $resolver, ButtonGuesser $guesser, ButtonNormalizer $normalizer)
    {
        $this->guesser    = $guesser;
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read builder button input.
     *
     * @param ControlPanelBuilder $builder
     * @return array
     */
    public function read(ControlPanelBuilder $builder)
    {
        $this->setInput($builder);
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
        $this->guessInput($builder);
    }

    /**
     * Set the actual input from the active section.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function setInput(ControlPanelBuilder $builder)
    {
        $buttons = [];

        $controlPanel  = $builder->getControlPanel();
        $sections = $controlPanel->getSections();
        $section  = $sections->active();

        if ($section instanceof SectionInterface) {
            $buttons = $section->getButtons();
        }

        $builder->setButtons($buttons);
    }

    /**
     * Resolve the button input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function resolveInput(ControlPanelBuilder $builder)
    {
        $builder->setButtons($this->resolver->resolve($builder->getButtons()));
    }

    /**
     * Normalize the button input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function normalizeInput(ControlPanelBuilder $builder)
    {
        $builder->setButtons($this->normalizer->normalize($builder->getButtons()));
    }

    /**
     * Guess the button input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function guessInput(ControlPanelBuilder $builder)
    {
        $builder->setButtons($this->guesser->guess($builder->getButtons()));
    }
}
