<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Translation\Translator;

/**
 * Class TitleGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser
 */
class TitleGuesser
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * The translator utility.
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new TitleGuesser instance.
     *
     * @param ModuleCollection $modules
     * @param Translator       $translator
     */
    public function __construct(ModuleCollection $modules, Translator $translator)
    {
        $this->modules    = $modules;
        $this->translator = $translator;
    }

    /**
     * Guess the sections title.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $sections = $builder->getSections();

        foreach ($sections as &$section) {

            // If title is set then skip it.
            if (isset($section['title'])) {
                continue;
            }

            $module = $this->modules->active();

            $section['title'] = $module->getNamespace('section.' . $section['slug'] . '.title');

            if (!$this->translator->has($section['title'])) {
                $section['title'] = $module->getNamespace('addon.section.' . $section['slug']);
            }
        }

        $builder->setSections($sections);
    }
}
