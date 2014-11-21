<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Expander;

/**
 * Class FormExpander
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Section
 */
class FormExpander extends Expander
{

    /**
     * Expand minimal fields input.
     *
     * @param array $section
     * @return mixed
     */
    public function expandLayout(array $section)
    {
        if (!isset($section['layout'])) {

            $fields  = array_get($section, 'fields', []);
            $columns = array_get($section, 'columns', [compact('fields')]);
            $rows    = array_get($section, 'rows', [compact('columns')]);
            $layout  = array_get($section, 'layout', compact('rows'));

            $section['layout'] = $layout;

            unset($section['fields'], $section['columns'], $section['rows']);
        }

        return $section;
    }
}
 