<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Section;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\Streams\Platform\Ui\Form\FormNormalizer;

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
     * Read the form section input.
     *
     * @param FormBuilder $builder
     */
    public function read(FormBuilder $builder)
    {
        $sections = $builder->getSections();
        $entry = $builder->getFormEntry();

        /**
         * Resolve & Evaluate
         */
        $sections = resolver($sections, compact('builder', 'entry'));

        $sections = $sections ?: $builder->getSections();

        $sections = evaluate($sections, compact('builder', 'entry'));

        $sections = FormNormalizer::sections($sections);
        $sections = FormNormalizer::attributes($sections);

        $sections = translate($sections);

        $builder->setSections($sections);
    }
}
