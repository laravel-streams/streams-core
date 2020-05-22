<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class SectionBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionBuilder
{

    /**
     * Build the sections.
     *
     * @param FormBuilder $builder
     */
    public static function build(FormBuilder $builder)
    {
        SectionInput::read($builder);

        foreach ($builder->sections as $slug => $section) {
            $builder->form->sections->put($slug, $section);
        }
    }
}
