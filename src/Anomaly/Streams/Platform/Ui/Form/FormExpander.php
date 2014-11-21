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
    public function expandFields(array $container)
    {
        if (!isset($container['layout'])) {

            $fields  = evaluate_key($container, 'fields', []);
            $columns = evaluate_key($container, 'columns', [compact('fields')]);
            $rows    = evaluate_key($container, 'rows', [compact('columns')]);
            $layout  = evaluate_key($container, 'layout', compact('rows'));

            $container['layout'] = $layout;

            unset($container['fields'], $container['columns'], $container['rows']);
        }

        return $container;
    }
}
 