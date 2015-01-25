<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Resolver;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionInput
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
 */
class SectionInput
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The section guesser.
     *
     * @var SectionGuesser
     */
    protected $guesser;

    /**
     * The resolver utility.
     *
     * @var Resolver
     */
    protected $resolver;

    /**
     * The section normalizer.
     *
     * @var SectionNormalizer
     */
    protected $normalizer;

    /**
     * Create a new SectionInput instance.
     *
     * @param Resolver          $resolver
     * @param SectionGuesser    $guesser
     * @param ModuleCollection  $modules
     * @param SectionNormalizer $normalizer
     */
    function __construct(
        Resolver $resolver,
        SectionGuesser $guesser,
        ModuleCollection $modules,
        SectionNormalizer $normalizer
    ) {
        $this->guesser    = $guesser;
        $this->modules    = $modules;
        $this->resolver   = $resolver;
        $this->normalizer = $normalizer;
    }

    /**
     * Read the section input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     */
    public function read(ControlPanelBuilder $builder)
    {
        $this->setInput($builder);
        $this->resolveInput($builder);
        $this->normalizeInput($builder);
        $this->guessInput($builder);
    }

    /**
     * Set the section input from the active module.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function setInput(ControlPanelBuilder $builder)
    {
        $module = $this->modules->active();

        $builder->setSections($module->getSections());
    }

    /**
     * Resolve the section input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function resolveInput(ControlPanelBuilder $builder)
    {
        $builder->setSections($this->resolver->resolve($builder->getSections()));
    }

    /**
     * Normalize the section input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function normalizeInput(ControlPanelBuilder $builder)
    {
        $builder->setSections($this->normalizer->normalize($builder->getSections()));
    }

    /**
     * Guess the section input.
     *
     * @param ControlPanelBuilder $builder
     */
    protected function guessInput(ControlPanelBuilder $builder)
    {
        $builder->setSections($this->guesser->guess($builder->getSections()));
    }
}
