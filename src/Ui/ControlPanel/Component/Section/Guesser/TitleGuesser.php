<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section\Guesser;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Support\Str;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Translation\Translator;

/**
 * Class TitleGuesser
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class TitleGuesser
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * @var Str
     */
    protected $string;

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
     * @param Repository       $config
     * @param Str              $string
     */
    public function __construct(ModuleCollection $modules, Translator $translator, Repository $config, Str $string)
    {
        $this->config     = $config;
        $this->string     = $string;
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
        if (!$module = $this->modules->active()) {
            return;
        }
        
        $sections = $builder->getSections();

        foreach ($sections as &$section) {

            // If title is set then skip it.
            if (isset($section['title'])) {
                continue;
            }

            $title = $module->getNamespace('section.' . $section['slug'] . '.title');

            if (!isset($section['title']) && $this->translator->has($title)) {
                $section['title'] = $title;
            }

            $title = $module->getNamespace('addon.section.' . $section['slug']);

            if (!isset($section['title']) && $this->translator->has($title)) {
                $section['title'] = $title;
            }

            if (!isset($section['title']) && $this->config->get('streams::system.lazy_translations')) {
                $section['title'] = ucwords($this->string->humanize($section['slug']));
            }

            if (!isset($section['title'])) {
                $section['title'] = $title;
            }
        }

        $builder->setSections($sections);
    }
}
