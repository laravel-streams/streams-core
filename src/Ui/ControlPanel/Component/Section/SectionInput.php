<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\Ui\Support\Normalizer;

/**
 * Class SectionInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
     * Create a new SectionInput instance.
     *
     * @param SectionGuesser    $guesser
     * @param ModuleCollection  $modules
     */
    public function __construct(
        SectionGuesser $guesser,
        ModuleCollection $modules
    ) {
        $this->guesser    = $guesser;
        $this->modules    = $modules;
    }

    /**
     * Read the section input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     */
    public function read(ControlPanelBuilder $builder)
    {
        $sections = $builder->getSections();

        $sections = resolver($sections, compact('builder'));

        $sections = evaluate($sections ?: $builder->getSections(), compact('builder'));

        $sections = Normalizer::sections($sections);

        $builder->setSections($sections);

        $this->guesser->guess($builder);

        $sections = $builder->getSections();

        $sections = evaluate($sections, compact('builder'));
        $sections = parse($sections);

        $builder->setSections($sections);

        $builder->setSections(translate($builder->getSections()));
    }
}
