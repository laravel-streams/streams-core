<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Authorizer;
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
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new TextGuesser instance.
     *
     * @param ModuleCollection $modules
     * @param Authorizer       $authorizer
     */
    public function __construct(ModuleCollection $modules, Authorizer $authorizer)
    {
        $this->modules    = $modules;
        $this->authorizer = $authorizer;
    }

    /**
     * Guess the sections text.
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
