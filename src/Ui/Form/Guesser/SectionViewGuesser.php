<?php namespace Anomaly\Streams\Platform\Ui\Form\Guesser;

/**
 * Class SectionViewGuesser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Guesser
 */
class SectionViewGuesser
{

    /**
     * Guess the sections view if not provided.
     *
     * @param array $section
     */
    public function guess(array &$section)
    {
        /**
         * If the view is already set then
         * we really don't have anything to do.
         */
        if (isset($section['view'])) {
            return;
        }

        /**
         * If the section has a fields key
         * then assume it's a default section.
         */
        if (isset($section['fields'])) {
            $section['view'] = 'streams::ui/form/partials/default';
        }

        /**
         * If the section has a tabs key
         * then assume it's a tabbed section.
         */
        if (isset($section['tabs'])) {
            $section['view'] = 'streams::ui/form/partials/tabbed';
        }
    }
}
