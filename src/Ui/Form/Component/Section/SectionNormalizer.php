<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionNormalizer
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Section
 */
class SectionNormalizer
{

    /**
     * Normalize the sections.
     *
     * @param FormBuilder $builder
     */
    public function normalize(FormBuilder $builder)
    {
        $sections = $builder->getSections();

        foreach ($sections as $slug => &$section) {

            if (is_string($section)) {
                $section = [
                    'view' => $section
                ];
            }
        }

        $builder->setSections($sections);
    }
}
