<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Addon\Module\ModuleCollection;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionNormalizer.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
 */
class SectionNormalizer
{
    /**
     * The module collection.
     *
     * @var ModuleCollection
     */
    protected $modules;

    /**
     * Create a new SectionNormalizer instance.
     *
     * @param ModuleCollection $modules
     */
    public function __construct(ModuleCollection $modules)
    {
        $this->modules = $modules;
    }

    /**
     * Normalize the section input.
     *
     * @param ControlPanelBuilder $builder
     */
    public function normalize(ControlPanelBuilder $builder)
    {
        $sections = $builder->getSections();

        /*
         * Loop over each section and make sense of the input
         * provided for the given module.
         */
        foreach ($sections as $slug => &$section) {

            /*
             * If the slug is not valid and the section
             * is a string then use the section as the slug.
             */
            if (is_numeric($slug) && is_string($section)) {
                $section = [
                    'slug' => $section,
                ];
            }

            /*
             * If the slug is a string and the text is not
             * set then use the slug as the slug.
             */
            if (is_string($slug) && ! isset($section['slug'])) {
                $section['slug'] = $slug;
            }

            /*
             * Make sure we have attributes.
             */
            $section['attributes'] = array_get($section, 'attributes', []);

            /*
             * Move the HREF into attributes.
             */
            if (isset($section['href'])) {
                $section['attributes']['href'] = array_pull($section, 'href');
            }

            /*
             * Make sure the HREF is absolute.
             */
            if (
                isset($section['attributes']['href']) &&
                is_string($section['attributes']['href']) &&
                ! starts_with($section['attributes']['href'], 'http')
            ) {
                $section['attributes']['href'] = url($section['attributes']['href']);
            }
        }

        $builder->setSections(array_values($sections));
    }
}
