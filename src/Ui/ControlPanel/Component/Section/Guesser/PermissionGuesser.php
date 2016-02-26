<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

class PermissionGuesser
{

    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new TitleGuesser instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Guess the sections title.
     *
     * @param ControlPanelBuilder $builder
     */
    public function guess(ControlPanelBuilder $builder)
    {
        $module = $this->modules->active();

        $sections = $builder->getSections();

        foreach ($sections as &$section) {

            // If permission is set then skip it.
            if (isset($section['permission'])) {
                return;
            }

            $section['permission'] = $module->getNamespace($section['slug'] . '.*');
        }

        $builder->setSections($sections);
    }
}
