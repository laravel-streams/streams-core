<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Translation\Translator;

/**
 * Class DescriptionGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser
 */
class DescriptionGuesser
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
     * Create a new DescriptionGuesser instance.
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
     * Guess the sections description.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $sections = $builder->getSections();

        foreach ($sections as &$section) {

            // If description is set then skip it.
            if (isset($section['description'])) {
                continue;
            }

            $module = $this->modules->active();

            $description = $module->getNamespace('section.' . $section['slug'] . '.description');

            if ($this->translator->has($description)) {
                $section['description'] = $description;
            }
        }

        $builder->setSections($sections);
    }
}
